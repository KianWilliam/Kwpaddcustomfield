<?php 
/*
  * @package plugin kwpaddcustomfield for Joomla! 5.x
 * @version $Id: kwpaddcustomfield 1.0.0 2025-07-25 01:10:10Z $
 * @author KWProductions Co.
 * @copyright (C) 2022- KWProductions Co.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of kwpaddcustomfield.
    kwpaddcustomfield is free software: you can redistribute it and/or adify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    kwpaddcustomfield is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for are details.
    You should have received a copy of the GNU General Public License
    along with kwpaddcustomfield.  If not, see <http://www.gnu.org/licenses/>.
 
*/

?>
<?php
\defined('_JEXEC') or die;


use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;

use Joomla\CMS\Form\Field\ModalSelectField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;


class JFormFieldComponentlist extends  ModalSelectField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $type = 'componentlist';

	/**
	 * Method to attach a Form object to the field.
	 *
	 * @param   \SimpleXMLElement  $element  The SimpleXMLElement object representing the `<field>` tag for the form field object.
	 * @param   mixed              $value    The form field value to validate.
	 * @param   string             $group    The field name group control value.
	 *
	 * @return  boolean  True on success.
	 *
	 * @see     FormField::setup()
	 * @since   5.0.0
	 */
	public function setup(\SimpleXMLElement $element, $value, $group = null)
	{
		$infos = $this->getLayoutData();
		$val = $infos['value'];
		
       // Get the field
       $result = parent::setup($element, $value, $group);

		if (!$result)
		{
			return $result;
		}

		$app = Factory::getApplication();
		
       $doc = $app->getDocument();
       $wa = $doc->getWebAssetManager();
    

      
		$urlSelect = (new Uri())->setPath(Uri::base(true) . '/index.php');
		$urlSelect->setQuery([
			'option'                => 'com_ajax',
			'plugin'                => 'kwpaddcustomfield',
			'group'                 => 'content',
			'method'                => 'kwpaddcustomfield',
			'format'                => 'html',
			'tmpl'                  => 'component',
			Session::getFormToken() => 1,
		]);

		$modalTitle = Text::_('Select an Item:');
		$this->urls['select'] = (string) $urlSelect;

		
		$this->modalTitles['select'] = $modalTitle;

		$this->hint = $this->hint ?: Text::_('Select an item from the field:');
        $result = $val .",". $result;
		return $result;
	}
	 /**
	 * The method shows the name of the selected product in the placeholder field.
	 *
	 * @return string
	 *
	 * @since   5.0.0
	 */
	protected function getValueTitle()
	{
		$value = (int) $this->value; 
		$title = '';
         $session = Factory::getSession();
		 $tablename = $session->get("tablename");
	
		if ($value)
		{
			try
			{
				  $db = Factory::getDbo();
				  $query = $db->getQuery(true);		   	
		   $query->select('*')->from($db->quoteName($tablename))->where(' id = '.$db->quote($value));
						$db->setQuery($query);
						$result = $db->loadObject();
			
				if(isset($result->name) && $result->name!==NULL)
				$title = $result->name;
			    else
					$title = $result->title;
			}
			catch (\Throwable $e)
			{
				Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
			}
		}
		return $title ?: $value;
	}
	
}