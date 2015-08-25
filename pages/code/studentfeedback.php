<?php
class StudentFeedback {
    public $id;
    public $name;
    public $photo;
    public $contacts;
    public $comment;
    public $shortComment;
    public $middleComment;
    public $course;

    function __construct() {
        $this->contacts = array();
    }

    public function addContact($contact) {
        array_push($this->contacts, $contact);
    }

    public function setComment($comment) {
        $this->comment = htmlspecialchars($comment);
        $this->shortComment = $this->shortenText($this->comment, 380);
        $this->middleComment = $this->shortenText($this->comment, 850);
    }

    private function shortenText($text, $len) {
        if(strlen($text) < $len) {
            return $text;
        }
        $ret = substr($text, 0, $len);
        $lastSpacePos = strripos($ret, ' ');
        if($lastSpacePos < 0) return;
        return substr($ret, 0, $lastSpacePos);
    }
}

class StudentFeedbackContact {
    public $type;
    public $link;

    function __construct($type, $link)
    {
        $this->type = $type;
        $this->link = $link;
    }

    public function getPresentation() {
        if($this->type === 'facebook') {
            return '<a target="_blank"  href="'.$this->link.'">Facebook</a>';
        }
        else if($this->type === 'vk') {
            return '<a target="_blank"  href="'.$this->link.'">ВКонтакте</a>';
        }
        else if($this->type === 'tel') {
            return '<span>Телефон: </span>'.$this->link;
        }
        else if($this->type === 'skype') {
            return '<span>Skype: </span><a href="skype:'.$this->link.'">'.$this->link.'</a>';
        }
    }
}

class StudentFeedbacks {
    static private $feedbacks = array();

    static function getAllFeedbacks() {
        return self::$feedbacks;
    }

    static function addFeedback($feedback) {
        array_push(self::$feedbacks, $feedback);
    }

    static function getCount() {
        return count(self::$feedbacks);
    }

    static function getFrom($from) {
        if(!is_numeric($from)) $from = 0;
        $to = $from + 2;
        $count = self::getCount();
        $ret = array();

        for($i = $from; $i < $to; $i++) {
            $pos = $i % $count;
            array_push($ret, self::$feedbacks[($pos < 0 ? ($count + $pos) : $pos)]);
        }
        return $ret;
    }
}
