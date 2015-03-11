<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// Require the base class.
require_once __DIR__ . "/../BaseExample.php";

/**
 * This example illustrates how to retrieve a creative.
 *
 * Tags: creatives.get
 *
 * @author David Torres <david.t@google.com>
 * @author Mark Saniscalchi <api.msaniscalchi@google.com>
 */
class ListCreatives extends BaseExample {
  /**
   * (non-PHPdoc)
   * @see BaseExample::getInputParameters()
   */
  protected function getInputParameters() {
    return array(array('name' => 'nextpage_token',
                       'display' => 'nextPageToken',
                       'required' => false));
  }

  /**
   * (non-PHPdoc)
   * @see BaseExample::run()
   */
  public function run() {
    $values = $this->formValues;
    $optParams = array('maxResults' => 1000);
    if (!empty($values['nextpage_token'])) {
      $optParams['pageToken'] = $values['nextpage_token'];
    }
    $result = $this->service->creatives->listCreatives($optParams);

    print '<h2>Listing creatives</h2>';
    if (!isset($result['items']) || !count($result['items'])) {
      print '<p>No creatives found</p>';
      return;
    } else {
      $this->printResult('nextPageToken: ' . $result['nextPageToken']);
      $i = 0;
      foreach ($result['items'] as $creative) {
        $i++;
        $this->printResult("*** $i ***************************");
        $this->printResult($creative);
      }
    }
  }

  /**
   * (non-PHPdoc)
   * @see BaseExample::getName()
   */
  public function getName() {
    return 'List Creatives';
  }
}

