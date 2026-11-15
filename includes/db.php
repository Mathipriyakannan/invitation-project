<?php
// Database connection (XAMPP default). Import athen_database.sql in phpMyAdmin first.
const DB_HOST='localhost',

DB_NAME='athen_database',
DB_USER='root',DB_PASS='';

function db(){static $p=null,$t=false;if($t)return $p;$t=true;
 try{$p=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);}
 catch(Throwable $e){error_log('ATHEN DB: '.$e->getMessage());$p=null;}
 return $p;}

function price_fmt($v){$v=(float)$v;return '₹'.(fmod($v,1)==0?(string)(int)$v:rtrim(rtrim(number_format($v,2,'.',''),'0'),'.'));}
function row_item($r,$kind){$ty=$GLOBALS['types']??[];
 return ['id'=>(int)$r['id'],'type'=>$r['type']??'','name'=>$r['name'],'desc'=>$r['description']??'','price'=>price_fmt($r['price']),'priceval'=>(float)$r['price'],
  'icon'=>$kind==='b'?'🛍️':($ty[$r['type']][2]??'🎴'),'image'=>$r['image']??null,'image2'=>$r['image_back']??null,'code'=>$r['code']??'','heading'=>$r['heading']??'','subtitle'=>$r['subtitle']??'','content'=>$r['content']??'','extras'=>[]];}
// Extra book images of every card: [card_id => [['id'=>..,'image'=>..], ...]] (empty if the card_images table is not created yet)
function card_extras($p){$m=[];try{foreach($p->query('SELECT id,card_id,image FROM card_images ORDER BY sort_no,id')->fetchAll() as $r)$m[(int)$r['card_id']][]=['id'=>(int)$r['id'],'image'=>$r['image']];}catch(Throwable $e){}return $m;}
// Extra book images of every gift bag: [bag_id => [['id'=>..,'image'=>..], ...]] (empty if the bag_images table is not created yet)
function bag_extras($p){$m=[];try{foreach($p->query('SELECT id,bag_id,image FROM bag_images ORDER BY sort_no,id')->fetchAll() as $r)$m[(int)$r['bag_id']][]=['id'=>(int)$r['id'],'image'=>$r['image']];}catch(Throwable $e){}return $m;}
function db_rows($t){$p=db();if(!$p)return [];$ex=$t==='cards'?card_extras($p):($t==='bags'?bag_extras($p):[]);
 return array_map(function($r)use($t,$ex){$i=row_item($r,$t==='bags'?'b':'c');$i['extras']=$ex[(int)$r['id']]??[];return $i;},$p->query("SELECT * FROM $t ORDER BY id")->fetchAll());}
function db_cards(){return db_rows('cards');}
function db_bags(){return db_rows('bags');}

// Saves an uploaded image into /uploads. Returns [relative path|null, error|null].
function save_image($f){
 if(!$f||!isset($f['error'])||$f['error']===UPLOAD_ERR_NO_FILE)return [null,null];
 if($f['error']!==UPLOAD_ERR_OK)return [null,'Image upload failed (code '.$f['error'].')'];
 if($f['size']>5*1024*1024)return [null,'Image must be smaller than 5 MB'];
 $i=@getimagesize($f['tmp_name']);$map=[IMAGETYPE_JPEG=>'jpg',IMAGETYPE_PNG=>'png',IMAGETYPE_GIF=>'gif',IMAGETYPE_WEBP=>'webp'];
 if(!$i||!isset($map[$i[2]]))return [null,'Only JPG, PNG, GIF or WEBP images are allowed'];
 $dir=__DIR__.'/../uploads';if(!is_dir($dir))@mkdir($dir,0755,true);
 $n=bin2hex(random_bytes(8)).'.'.$map[$i[2]];
 if(!@move_uploaded_file($f['tmp_name'],$dir.'/'.$n))return [null,'Could not save the image (uploads folder not writable)'];
 return ['uploads/'.$n,null];}
function drop_image($path){if($path&&strpos($path,'uploads/')===0&&strpos($path,'..')===false)@unlink(__DIR__.'/../'.$path);}

// ---- Card / bag IDs: one letter per category + running number (B1, B2 ... W1 ... T1) ----
const CODE_LETTERS=['birthday'=>'B','earpiercing'=>'E','housewarming'=>'H','wedding'=>'W','babyshower'=>'S','opening'=>'O','welcome'=>'V','thanks'=>'N','personalized'=>'P','betrothal'=>'R','baptism'=>'A','communion'=>'M','puberty'=>'U','scroll'=>'L'];
function code_letter($kind,$type=''){return $kind==='bags'?'T':(CODE_LETTERS[$type]??'C');}
function next_code($p,$kind,$type=''){$L=code_letter($kind,$type);$t=$kind==='bags'?'bags':'cards';
 $q=$p->prepare("SELECT MAX(CAST(SUBSTRING(code,2) AS UNSIGNED)) FROM $t WHERE code REGEXP ?");$q->execute(['^'.$L.'[0-9]+$']);
 return $L.(((int)$q->fetchColumn())+1);}
// Adds the new columns (image_back, code) if the SQL update was not run, and gives IDs to old rows that have none.
function ensure_schema($p){
 foreach(['cards'=>['image_back','code'],'bags'=>['code','image_back']] as $t=>$cols)foreach($cols as $c){
  try{$p->query("SELECT $c FROM $t LIMIT 1");}catch(Throwable $e){try{$p->exec("ALTER TABLE $t ADD COLUMN $c VARCHAR(".($c==='code'?10:255).") DEFAULT NULL");}catch(Throwable $e2){}}}
 /* View Book: optional heading / subtitle / content on every card + any number of extra images (table card_images) */
 foreach(['cards','bags'] as $t0)foreach(['heading'=>'VARCHAR(200)','subtitle'=>'VARCHAR(255)','content'=>'TEXT'] as $c=>$ty){
  try{$p->query("SELECT $c FROM $t0 LIMIT 1");}catch(Throwable $e){try{$p->exec("ALTER TABLE $t0 ADD COLUMN $c $ty DEFAULT NULL");}catch(Throwable $e2){}}}
 try{$p->exec("CREATE TABLE IF NOT EXISTS bag_images (id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,bag_id INT UNSIGNED NOT NULL,image VARCHAR(255) NOT NULL,sort_no INT NOT NULL DEFAULT 0,created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,KEY bag_id (bag_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");}catch(Throwable $e){}
 try{$p->exec("CREATE TABLE IF NOT EXISTS card_images (id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,card_id INT UNSIGNED NOT NULL,image VARCHAR(255) NOT NULL,sort_no INT NOT NULL DEFAULT 0,created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,KEY card_id (card_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");}catch(Throwable $e){}
 foreach(['cards','bags'] as $t){try{
  $rows=$p->query("SELECT id,".($t==='cards'?'type':"''")." AS type FROM $t WHERE code IS NULL OR code='' ORDER BY id")->fetchAll();
  foreach($rows as $r)$p->prepare("UPDATE $t SET code=? WHERE id=?")->execute([next_code($p,$t,$r['type']),$r['id']]);
 }catch(Throwable $e){}}}