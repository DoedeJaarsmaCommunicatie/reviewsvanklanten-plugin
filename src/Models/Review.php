<?php

namespace Reviewsvanklanten\Models;

use http\Exception\InvalidArgumentException;

class Review
{
    private $id;
    private $uuid;
    private $name;
    private $email;

    protected $remarks;
    protected $score = 0.0;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->remarks = $data['remarks'];
            $this->score = (float) $data['score'];
            $this->id = $data['id'];
            $this->uuid = $data['uuid'];
            $this->name = $data['name'];
            $this->email = $data['email'];
        }
    }

    public function set_email($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Not a valid email');
        }

        $this->email = $email;
    }

    public function get_email()
    {
        return $this->email;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function get_name()
    {
        return $this->name?? '';
    }

    public function get_name_or_email()
    {
        return $this->get_name()?? $this->get_email();
    }


    public function get_uuid()
    {
        return $this->uuid;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_remarks($remarks)
    {
        $this->remarks = $remarks;
    }

    public function get_remarks()
    {
        return $this->remarks?? '';
    }

    public function set_score($score)
    {
        $score = (float) $score;

        if ($score > 10) {
            $score = 10.0;
        }

        if ($score < 1) {
            $score = 1.0;
        }

        $this->score = $score;
    }

    public function get_score()
    {
        return (float) $this->score;
    }

    public function __toString()
    {
        return (string) $this->score;
    }
}
