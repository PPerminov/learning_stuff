<?php
namespace Perminov\Unit;

class Unit
{
  public function getId()
  {
      try {
          return $this->id;
      } finally {
          return null;
      }
  }
  public function getName()
  {
      try {
          return $this->name;
      } finally {
          return null;
      }
  }
}
