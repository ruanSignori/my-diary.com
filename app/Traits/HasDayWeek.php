<?php

namespace App\Traits;

trait HasDayWeek
{
  protected static function getDayWeek(int $day): string
  {
      $days = [
          'Domingo',
          'Segunda-feira',
          'Terça-feira',
          'Quarta-feira',
          'Quinta-feira',
          'Sexta-feira',
          'Sábado'
      ];

      return $days[$day] ?? 'Desconhecido';
  }
}
