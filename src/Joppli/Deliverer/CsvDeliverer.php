<?php

namespace Joppli\Deliverer;

use
Joppli\Filter\ConcatNestedArrayFilter,
Joppli\Response\ResponseService,
Joppli\Validator\Exception\ValidatorException,
Joppli\Validator\MultiDimensionalArrayValidator;

class CsvDeliverer extends AbstractDeliverer
{
  protected
  $concatFilter,
  $multiDimensionalValidator;

  public function __construct(
    ResponseService $service,
    ConcatNestedArrayFilter $concatFilter,
    MultiDimensionalArrayValidator $multiDimensionalValidator)
  {
    parent::__construct($service);
    $this->concatFilter = $concatFilter;
    $this->multiDimensionalValidator = $multiDimensionalValidator;
  }

  protected function composeOutput(array $entity)
  {
    $f = fopen('php://memory', 'rw');

    // making sure we using a multi dimensional entity
    try
    {
      $this->multiDimensionalValidator->validate($entity);
    }
    catch(ValidatorException $e)
    {
      $entity = [$entity];
    }

    foreach ($entity as $line)
    {
      fputcsv($f, array_keys($line), ',');
      break;
    }

    foreach ($entity as $line)
      fputcsv($f, $this->filter($line), ',');

    fseek($f, 0);

    $csv = stream_get_contents($f);
    fclose($f);

    return $csv;
  }

  protected function filter(array $line)
  {
    foreach($line as &$cell)
      $cell = $this->concatFilter->filter($cell);

    return $line;
  }
}
