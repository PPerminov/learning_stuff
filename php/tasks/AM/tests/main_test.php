<?php

require 'test_task.php';

class DTests extends PHPUnit_Framework_TestCase
{
    private $headers = [["жесть", "удивительно", "снова", "совсем", "шок", "случай", "сразу", "событие", "начало", "вирус"],
                    ["currency", "amazing", "again", "absolutely", "shocking", "case", "immediately", "event", "beginning", "virus"]];
    private $dicts=[["один", "еще", "бы", "такой", "только", "себя", "свое", "какой", "когда", "уже", "для", "вот", "кто", "да", "говорить", "год", "знать", "мой", "до", "или", "если", "время", "рука", "нет", "самый", "ни", "стать", "большой", "даже", "другой", "наш", "свой", "ну", "под", "где", "дело", "есть", "сам", "раз", "чтобы", "два", "там", "чем", "глаз", "жизнь", "первый", "день", "тута", "во", "ничто", "потом", "очень", "со", "хотеть", "ли", "при", "голова", "надо", "без", "видеть", "идти", "теперь", "тоже", "стоять", "друг", "дом", "сейчас", "можно", "после", "слово", "здесь", "думать", "место", "спросить", "через", "лицо", "что", "тогда", "ведь", "хороший", "каждый", "новый", "жить", "должный", "смотреть", "почему", "потому", "сторона", "просто", "нога", "сидеть", "понять", "иметь", "конечный", "делать", "вдруг", "над", "взять", "никто", "сделать"],
["one", "yet", "would", "such", "only", "yourself", "his", "what", "when", "already", "for", "behold", "Who", "yes", "speak", "year", "know", "my", "before", "or", "if", "time", "arm", "no", "most", "nor", "become", "big", "even", "other", "our", "his", "well", "under", "where", "a business", "there is", "himself", "time", "that", "two", "there", "than", "eye", "a life", "first", "day", "mulberry", "in", "nothing", "later", "highly", "with", "to want", "whether", "at", "head", "need", "without", "see", "go", "now", "also", "stand", "friend", "house", "now", "can", "after", "word", "here", "think", "a place", "ask", "across", "face", "what", "then", "after all", "good", "each", "new", "live", "due", "look", "why", "because", "side", "just", "leg", "sit", "understand", "have", "finite", "do", "all of a sudden", "above", "to take", "no one", "make"]];
    private $data = [
'authors'=>["CrazyNews", "Чук и Гек", "CatFuns", "CarDriver", "BestPics", "ЗОЖ", "Вася Пупкин", "Готовим со вкусом", "Шахтёрская Правда", "FunScience"],
'Languages'=>["Русский", "English"]
];

    private $tables=[
'create table if not exists Authors (id integer primary key AUTOINCREMENT, name varchar(128));',
'create table if not exists Languages (id integer primary key AUTOINCREMENT, name varchar(32));',
'create table if not exists Posts (id integer primary key AUTOINCREMENT,
                                   langId integer,
                                   authorId integer,
                                   date date,
                                   header varchar(255),
                                   body text,
                                   likes int,
                                   foreign key (langId) references Languages(id) on delete cascade,
                                   foreign key (authorId) references Authors(id) on delete cascade);'];



    private function prepareTables()
    {
        $db = new PDO('sqlite::memory:', null, null, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,\PDO::ATTR_PERSISTENT => true,\PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC]);
        foreach ($this->tables as $table) {
            $db->exec($table);
        }
        foreach ($this->data as $table => $values) {
            $prepared = $db->prepare(sprintf('insert into %s (name) values (?)', $table));
            foreach ($values as $value) {
                $prepared->execute([$value]);
            }
        }
        $this->db=$db;
    }

    public function setUp()
    {
        $this->prepareTables();
    }
    public function tearDown()
    {
        $this->db=null;
    }
    public function min_max($accum,$data) { //Тут я не доделал функцию, которая считает минимальное и максимальное количество слов в предложении, самих предложений и слов в заголовке
      $bare_text_counter = array_map(
        function($x){
          return explode(' ',$x);
        },
        explode('. ',$data['text']));
        foreach ($bare_text_counter as $item){
          if (count($item) > $accum['text']['sentence']['max']) {
            $accum['text']['sentence']['max'] = count($item);
          }
          if (count($item) < $accum['text']['sentence']['min']) {
            $accum['text']['sentence']['min'] = count($item);
          }
        }
      $header_counter = sizeOf(explode(' ',$data['header']));
      if ($header_counter < $accum['header']['min']){
        $accum['header']['min'] = $header_counter;
      }
      if ($header_counter > $accum['header']['max']){
        $accum['header']['max'] = $header_counter;
      }
      if ($text_counter < $accum['text']['min']){
        $accum['text']['min'] = $text_counter;
      }
      if ($text_counter > $accum['text']['max']){
        $accum['text']['max'] = $text_counter;
      }
      return $accum;
    }
    public function testsNumber1()
    {
        $counter = 20000;
        mainGenerator($this->db, $this->dicts, $this->headers, $counter);
        $this->assertEquals($this->db->query('select count() from posts')->fetchAll()[0]['count()'], $counter);
    }
    // public function testsNumber2()
    // {
    //     $counter = 500;
    //     mainGenerator($this->db, $this->dicts, $this->headers, $counter);
    //     $data = $this->db->query('select * from posts')->fetchAll();
    //     $accum=['text'=>['sentence'=>['min'=>666,'max'=>0],'min'=>666,'max'=>0],'header' =>['max'=>0,'min'=>666]];
    //     $data=array_reduce($data,$this->min_max,$accum);
    //     $this->assertEquals($data, $counter);
    // }
}
