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

class AssistantGroundingRankerMediaGroundingProviderFeatures extends \Google\Model
{
  /**
   * @var bool
   */
<<<<<<< HEAD
=======
  public $isCastVideo;
  /**
   * @var bool
   */
>>>>>>> develop
  public $isSeedRadio;
  /**
   * @var bool
   */
  public $isSeedRadioRequest;
  /**
   * @var float
   */
  public $mscRate;
<<<<<<< HEAD
=======
  public $scubedPSaiMusic;
>>>>>>> develop

  /**
   * @param bool
   */
<<<<<<< HEAD
=======
  public function setIsCastVideo($isCastVideo)
  {
    $this->isCastVideo = $isCastVideo;
  }
  /**
   * @return bool
   */
  public function getIsCastVideo()
  {
    return $this->isCastVideo;
  }
  /**
   * @param bool
   */
>>>>>>> develop
  public function setIsSeedRadio($isSeedRadio)
  {
    $this->isSeedRadio = $isSeedRadio;
  }
  /**
   * @return bool
   */
  public function getIsSeedRadio()
  {
    return $this->isSeedRadio;
  }
  /**
   * @param bool
   */
  public function setIsSeedRadioRequest($isSeedRadioRequest)
  {
    $this->isSeedRadioRequest = $isSeedRadioRequest;
  }
  /**
   * @return bool
   */
  public function getIsSeedRadioRequest()
  {
    return $this->isSeedRadioRequest;
  }
  /**
   * @param float
   */
  public function setMscRate($mscRate)
  {
    $this->mscRate = $mscRate;
  }
  /**
   * @return float
   */
  public function getMscRate()
  {
    return $this->mscRate;
  }
<<<<<<< HEAD
=======
  public function setScubedPSaiMusic($scubedPSaiMusic)
  {
    $this->scubedPSaiMusic = $scubedPSaiMusic;
  }
  public function getScubedPSaiMusic()
  {
    return $this->scubedPSaiMusic;
  }
>>>>>>> develop
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AssistantGroundingRankerMediaGroundingProviderFeatures::class, 'Google_Service_Contentwarehouse_AssistantGroundingRankerMediaGroundingProviderFeatures');
