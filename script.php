<?php 

/**
 * @package Plugin content - kwpaddcustomfield for Joomla! 5.x
 * @version $Id: content - kwpaddcustomfield  1.0.0 2022-06-10 23:26:33Z $
 * @author KWProductions Co.
 * @copyright (C) 2020- KWProductions Co.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 
 This file is part of content - kwpaddcustomfield.
    content - kwpaddcustomfield is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    It is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with it.  If not, see <http://www.gnu.org/licenses/>.
 
**/


?>
<?php

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerScript;

class PlgContentKwpaddcustomfieldInstallerScript extends InstallerScript
{
 public function install($parent)
 {
  
   
  $db  = Factory::getDbo();
  $query = $db->getQuery(true);
  $query->update('#__extensions');
  $query->set($db->quoteName('enabled') . ' = 1');
  $query->where($db->quoteName('element') . ' = ' . $db->quote('kwpaddcustomfield'));
  $query->where($db->quoteName('type') . ' = ' . $db->quote('plugin'));
  $db->setQuery($query);
  $db->execute(); 
   
  
 }
   public function uninstall($parent) 
  {
	 
	 
       
  }
}
