<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\Contentwarehouse;

<<<<<<< HEAD
class RepositoryWebrefAnnotationDebugInfo extends \Google\Collection
{
  protected $collection_key = 'infoString';
=======
class RepositoryWebrefAnnotationDebugInfo extends \Google\Model
{
>>>>>>> develop
  /**
   * @var string
   */
  public $description;
<<<<<<< HEAD
  /**
   * @var string[]
   */
  public $infoString;
  protected $rawClassificationType = EntitySignalsEntityClassification::class;
  protected $rawClassificationDataType = '';
  public $rawClassification;
  /**
   * @var string
   */
  public $url;
=======
>>>>>>> develop

  /**
   * @param string
   */
  public function setDescription($description)
  {
    $this->description = $description;
  }
  /**
   * @return string
   */
  public function getDescription()
  {
    return $this->description;
  }
<<<<<<< HEAD
  /**
   * @param string[]
   */
  public function setInfoString($infoString)
  {
    $this->infoString = $infoString;
  }
  /**
   * @return string[]
   */
  public function getInfoString()
  {
    return $this->infoString;
  }
  /**
   * @param EntitySignalsEntityClassification
   */
  public function setRawClassification(EntitySignalsEntityClassification $rawClassification)
  {
    $this->rawClassification = $rawClassification;
  }
  /**
   * @return EntitySignalsEntityClassification
   */
  public function getRawClassification()
  {
    return $this->rawClassification;
  }
  /**
   * @param string
   */
  public function setUrl($url)
  {
    $this->url = $url;
  }
  /**
   * @return string
   */
  public function getUrl()
  {
    return $this->url;
  }
=======
>>>>>>> develop
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(RepositoryWebrefAnnotationDebugInfo::class, 'Google_Service_Contentwarehouse_RepositoryWebrefAnnotationDebugInfo');
