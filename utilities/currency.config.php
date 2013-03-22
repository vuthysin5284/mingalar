<?php

$currency = new currency(50,"currency",3);
$country = new country(50,"country",3);

$currency->set_default = 1;

$currency = $currency->GetcurrencyInfoByset_default($currency);
$country->country_id =  $currency->country_id;

$country = $country->GetcountryInfoBycountry_id($country);
//Dollar
$config['currency_sign'] = $country->sign;
$config['currency'] = $country->currency;
$config['country_id'] = $country->country_id;

$currency->set_default = 0;

$currency = $currency->GetcurrencyInfoByset_default($currency);
$country->country_id =  $currency->country_id;

$country = $country->GetcountryInfoBycountry_id($country);
//Riel
$config1['currency_sign'] = $country->sign;
$config1['currency'] = $country->currency;
$config1['country_id'] = $country->country_id;

?>