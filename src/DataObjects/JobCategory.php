<?php
namespace Job;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\Core\Config\Config;

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class JobCategory extends DataObject
{
  public function Link(){
    return $this->JobsPage()->Link()."?cat=".$this->ID;
  }
  private static $table_name = 'JobCategory';
  /**
   * Belongs_many_many relationship
   * @var array
   */
  private static $belongs_many_many = [
    'Job' => Job::class,
  ];
  /**
   * Has_one relationship
   * @var array
   */
  private static $has_one = [
    'JobsPage' => JobsPage::class,
  ];
  /**
   * Database fields
   * @var array
   */
  private static $db = [
    'Title' => 'Text',
    'TagSortTitle'  =>  'Text',
    'Sort'  =>  'Int'
  ];
  /**
   * CMS Fields
   * @return FieldList
   */
  public function getCMSFields()
  {
    $fields = parent::getCMSFields();
    $fields->removeByName([
      'TagSortTitle',
      'Sort',
      'JobsPageID',
      'Job'
    ]);
    $fields->addFieldsToTab(
      'Root.Main',
      [
        TextField::create(
          'Title',
          'Titel'
        )
      ]
    );
    $this->extend('updateCMSFields', $fields);
    return $fields;
  }
  /**
   * Event handler called before writing to the database.
   */
  public function onBeforeWrite()
  {
    parent::onBeforeWrite();
    $this->TagSortTitle = $this->Title;
    $this->extend("updateOnBeforeWrite");
  }
}
