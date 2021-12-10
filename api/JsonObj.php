<?php

class JsonObj implements JsonSerializable {

    private $these = NULL;

    public function __construct()
    {

    }

    public function setThese($these) {
        $this->these = $these;
    }

    public function jsonSerialize(){
        return array(
            "Author" => $this->these->getAuthor(),
            "Author_id" => $this->these->getAuthorId(),
            "Title" => $this->these->getTitle(),
            "These_director" => $this->these->getTheseDirector(),
            "These_director_in_first_name" => $this->these->getTheseDirectorInFirstName(),
            "Director_id" => $this->these->getDirectorId(),
            "Location_sustenance" => $this->these->getLocationSustenance(),
            "Location_id" => $this->these->getLocationId(),
            "Discipline" => $this->these->getDiscipline(),
            "These_status" => $this->these->getStatus(),
            "Date_first_inscription_doc" => $this->these->getDateFirstInscriptionDoc(),
            "Date_sustenance" => $this->these->getDateSustenance(),
            "These_language" => $this->these->getTheseLanguage(),
            "These_id" => $this->these->getTheseId(),
            "Online_accessibility" => $this->these->getOnlineAccessibility(),
            "Date_publication" => $this->these->getDatePublication(),
            "Date_update_these" => $this->these->getDateUpdateThese(),
        );
    }

}