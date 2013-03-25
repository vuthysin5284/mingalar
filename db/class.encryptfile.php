<?php
  class TxtCrypt {

  var $m_inFileCarrier;
  var $m_inFile;
  var $m_outFile;
  var $m_key;
  var $m_keyLen;

  var $m_errMsg;

  function TxtCrypt() {
    $this->m_inFileCarrier = "";
    $this->m_inFile = "";
    $this->m_outFile = "";
    $this->m_key = "";
    $this->m_keyLen = 0;
    $this->m_errMsg = "";
    }

  function Encrypt($inFileCarrier, $inFile, $outFile, $key) {

    $this->m_inFileCarrier = $inFileCarrier;
    $this->m_inFile = $inFile;
    $this->m_outFile = $outFile;
    $this->m_key = $key;
    $this->m_keyLen = strlen($key);

    if (!file_exists($this->m_inFileCarrier)) {
      $this->m_errMsg = "Could not open carrier file '".$this->m_inFileCarrier."'";
      return false;
      }
    if (!file_exists($this->m_inFile)) {
      $this->m_errMsg = "Could not open input file '".$this->m_inFile."'";
      return false;
      }

    $carrierStr = file_get_contents($this->m_inFileCarrier);
    $cryptStr = $this->Crypt();

    if ($cryptStr != false) {
      $dwStr = $this->CryptDword(filesize($this->m_inFileCarrier));

      $fp = fopen($this->m_outFile, "w");
      fwrite($fp, $carrierStr.$cryptStr.$dwStr."\r\n");
      fclose($fp);
      return true;
      }

    return false;

    }

  function Decrypt($inFile, $outFile, $key) {

    $this->m_inFile = $inFile;
    $this->m_outFile = $outFile;
    $this->m_key = $key;
    $this->m_keyLen = strlen($key);

    if (!file_exists($this->m_inFile)) {
      $this->m_errMsg = "Could not open input file '".$this->m_inFile."'";
      return false;
      }

    $inFileStr = file_get_contents($this->m_inFile);

    $endStr = strrchr($inFileStr, "\r");
    if ($endStr == false || $endStr[1] != "\n") {
      $this->m_errMsg = "Could not decrypt input file '".$this->m_inFile."'";
      return false;
      }

    $dwBits = substr($inFileStr, strlen($inFileStr) - strlen($endStr) - 32, 32);
    $dwBin = $this->ConvertBitStringToBinary($dwBits);
    if ($dwBin == false) {
      $this->m_errMsg = "Could not decrypt input file '".$this->m_inFile."'";
      return false;
      }

    for ($i = 0; $i < 4; $i++)
      $dwBin[$i] = chr(ord($dwBin[$i]) ^ ord($this->m_key[$i % $this->m_keyLen]));

    $dwHex = "";
    for ($i = 3; $i >= 0; $i--)
      $dwHex .= sprintf("%02X", ord($dwBin[$i]));
    sscanf($dwHex, "%X", $dwLen);

    $bufSize = strlen($inFileStr) - strlen($endStr) - 32 - $dwLen;

    $outStr = $this->_decrypt(substr($inFileStr, $dwLen, $bufSize));
    if ($outStr == false) return false;

    $fp = fopen($this->m_outFile, "w");
    fwrite($fp, $outStr);
    fclose($fp);

    return true;

    }

  function Crypt() {

    $gzStr = @gzcompress(file_get_contents($this->m_inFile));
    if ($gzStr == false) {
      $this->m_errMsg = "Could not compress input data";
      return false;
      }

    $bitStr = "";
    for ($i = 0; $i < strlen($gzStr); $i++) {
      $b = ord($gzStr[$i]) ^ ord($this->m_key[$i % $this->m_keyLen]);
      $bitStr .= $this->ConvertToBitString($b);
      }

    return $bitStr;

    }

  function CryptDword($dw) {

    $dwHex = sprintf("%08X", $dw);
    $dwStr = "";
    for ($i = 6, $j = 0; $i >= 0; $i -= 2, $j = ($j + 1) % $this->m_keyLen) {
      sscanf(substr($dwHex, $i, 2), "%X", $b);
      $dwStr .= $this->ConvertToBitString($b ^ ord($this->m_key[$j]));
      }

    return $dwStr;

    }

  function ConvertToBitString($b) {

    $mask = 0x80;
    $bitstr = "";
    for ($i = 0; $i < 8; $i++) {
      $bitstr .= ($b & $mask) ? "\t" : " ";
      $mask >>= 1;
      }
    return $bitstr;
    }

  function ConvertBitStringToBinary($bitStr) {

    $mask = 0x80;
    $b = 0;
    $j = 0;
    $binStr = "";
    for ($i = 0; $i < strlen($bitStr); $i++) {
      if ($j == 0) { $b = 0;  $mask = 0x80; }
      if ($bitStr[$i] == "\t") $b |= $mask;
      else if ($bitStr[$i] != " ") {
        $this->m_errMsg = "Incorrect input data";
        return false;
        }
      $mask >>= 1;
      $j++;
      if ($j == 8) {
        $binStr .= chr($b);
        $j = 0;
        }
      }

    return $binStr;

    }

  function ConvertBitStringToHex($bitStr) {

    $mask = 0x80;
    $b = 0;
    $j = 0;
    $hexStr = "";
    for ($i = 0; $i < strlen($bitStr); $i++) {
      if ($j == 0) { $b = 0;  $mask = 0x80; }
      if ($bitStr[$i] == "\t") $b |= $mask;
      else if ($bitStr[$i] != " ") return false;
      $mask >>= 1;
      $j++;
      if ($j == 8) {
        $hexStr .= sprintf("%02X", $b);
        $j = 0;
        }
      }

    return $hexStr;

    }

  function _decrypt($inStr) {

    $outStr = $this->ConvertBitStringToBinary($inStr);
    if ($outStr == false) return false;

    for ($i = 0; $i < strlen($outStr); $i++) {
      $outStr[$i] = chr(ord($outStr[$i]) ^ ord($this->m_key[$i % $this->m_keyLen]));
      }

    $decStr = @gzuncompress($outStr);
    if ($decStr == false) {
      $this->m_errMsg = "Could not decompress the input data.";
      return false;
      }
    return $decStr;

    }

  function GetErrorMessage() {
    return "ERROR: ".$this->m_errMsg;
    }

}

?>