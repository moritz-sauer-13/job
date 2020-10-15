<?php

namespace Job\DataObjects;

use Job\JobsPage;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use Reference\Pages\ReferencePage;
use Reference\DataObjects\ReferenceCategory;
use SilverStripe\FontAwesome\FontAwesomeField;

class JobCircle extends DataObject
{
    private static $tablename = "JobCircle";
    private static $singular_name = 'JobCircle';

    private static $summary_fields = [
        "Hauptinfo" =>  "Hauptinfo",
        "Icon" =>  "Icon",
        "Zusatzinfo" =>  "Zusatzinfo",
    ];

    private static $db = [
        'Hauptinfo' => 'Text',
        'Zusatzinfo' => 'Text',
        'Icon' => 'Varchar',
    ];


    private static $has_one = [
        'JobsPage' => JobsPage::class,
    ];

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $this->URLSegment = $this->constructURLSegment();
    }

    private function constructURLSegment()
    {
        return $this->cleanLink(strtolower(str_replace(" ", "-", $this->Title)));
    }

    private function cleanLink($string)
    {
        $string = str_replace("ä", "ae", $string);
        $string = str_replace("ü", "ue", $string);
        $string = str_replace("ö", "oe", $string);
        $string = str_replace("Ä", "Ae", $string);
        $string = str_replace("Ü", "Ue", $string);
        $string = str_replace("Ö", "Oe", $string);
        $string = str_replace("ß", "ss", $string);
        $string = str_replace(["´", ",", ":", ";"], "", $string);
        return $string;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName([
            "Sort",
            'ReferencePageID'
        ]);


        $fields->addFieldToTab('Root.Main', TextField::create('Hauptinfo', 'Hauptinfo'));
        $fields->addFieldToTab('Root.Main', FontAwesomeField::create('Icon', 'Icon'));
        $fields->addFieldToTab('Root.Main', TextField::create('Zusatzinfo', 'Zusatzinfo'));


        return $fields;
    }

}
