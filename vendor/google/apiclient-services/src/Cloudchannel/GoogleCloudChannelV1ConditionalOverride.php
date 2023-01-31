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

namespace Google\Service\Cloudchannel;

class GoogleCloudChannelV1ConditionalOverride extends \Google\Model
{
  protected $adjustmentType = GoogleCloudChannelV1RepricingAdjustment::class;
  protected $adjustmentDataType = '';
  public $adjustment;
  /**
   * @var string
   */
  public $rebillingBasis;
  protected $repricingConditionType = GoogleCloudChannelV1RepricingCondition::class;
  protected $repricingConditionDataType = '';
  public $repricingCondition;

  /**
   * @param GoogleCloudChannelV1RepricingAdjustment
   */
  public function setAdjustment(GoogleCloudChannelV1RepricingAdjustment $adjustment)
  {
    $this->adjustment = $adjustment;
  }
  /**
   * @return GoogleCloudChannelV1RepricingAdjustment
   */
  public function getAdjustment()
  {
    return $this->adjustment;
  }
  /**
   * @param string
   */
  public function setRebillingBasis($rebillingBasis)
  {
    $this->rebillingBasis = $rebillingBasis;
  }
  /**
   * @return string
   */
  public function getRebillingBasis()
  {
    return $this->rebillingBasis;
  }
  /**
   * @param GoogleCloudChannelV1RepricingCondition
   */
  public function setRepricingCondition(GoogleCloudChannelV1RepricingCondition $repricingCondition)
  {
    $this->repricingCondition = $repricingCondition;
  }
  /**
   * @return GoogleCloudChannelV1RepricingCondition
   */
  public function getRepricingCondition()
  {
    return $this->repricingCondition;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudChannelV1ConditionalOverride::class, 'Google_Service_Cloudchannel_GoogleCloudChannelV1ConditionalOverride');
