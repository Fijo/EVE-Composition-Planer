<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;

class ComparsionService
{
  public function executeComparsion($comparsion, $a, $b) {
    $comparisonName = $comparsion->getName();

    switch ($comparisonName) {
      case 'Less than':
        return $this->getGeneralType($a) == $this->getGeneralType ($b) && $a < $b;
        break;

      case 'Equal to':
        return $this->getGeneralType($a) == $this->getGeneralType($b) && $a == $b;
        break;

      case 'Greater than':
        return $this->getGeneralType($a) == $this->getGeneralType($b) && $a > $b;
        break;

      case 'Starts with':
        return strpos($a,  $b) === 0;
        break;

      case 'Does not start with':
        return strpos($a,  $b) !== 0;
        break;

      case 'Is':
        return $this->getGeneralType($a) == $this->getGeneralType($b) && $this->isComparison($a, $b);
        break;

      case 'Is not':
        return $this->getGeneralType($a) != $this->getGeneralType($b) || !$this->isComparison($a, $b);
        break;

      case 'Contains':
        return strpos($a, $b) !== false;
        break;

      case 'Does not contain':
        return strpos($a, $b) === false;
        break;

      case 'And':
        return $a && $b;
        break;

      case 'Or':
        return $a || $b;
        break;

      default:
        die('Unknown comparison.name ´'.$comparisonName.'´.');
        break;
    }
  }

  private function isComparison($a, $b) {
    if(is_array($b))  {
      $count = count($b);
      if($count > 1)  {
        if(count($a) != $count || $a[0] != $b[0]) return false;

        for($i = 1; $i < $count; $i++)  {
          $bValue = $b[$i];
          if($bValue != 0 && $a[$i] != $bValue) return false;
        }
        return true;
      }
    }
    return $a == $b;

  }

  private function getGeneralType($obj) {
    $val = gettype($obj);
    if($val == 'integer') return 'double';
    return $val;
  }
}

?>