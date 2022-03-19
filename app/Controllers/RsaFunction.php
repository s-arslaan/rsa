<?php

namespace App\Controllers;

class RsaFunction extends BaseController
{
    public function index() {
        return view('rsa_function');
    }
    
    public function encrypt($a, $b, $text) {
        
        // smaller
        $p = $a > $b ? $b: $a;
        // larger
        $q = $a > $b ? $a: $b;

        $output = array();

        if(!$this->primeCheck($p) || !$this->primeCheck($q)) {
            $output[] = "---- P & Q should be Prime Numbers ----";
        }
        else if(abs($p-$q)<5) {
            $output[] = "---- Difference between numbers should be greater than 5 ----";
        }
        else {
            
            // RSA Modulus
            $n = $p * $q;
            // Eulers Toitent
            $r = ($p-1)*($q-1);

            $e = $this->e_value($r);
            $d = $this->multiplicative_inverse($e,$r);
            $str = str_split($text);

            $public_key = [$e,$n];
            $private_key = [$d,$n];
            
            $enc = array();
            $m = 0;
            $enc_value = null;
            foreach ($str as $char) {
                if(ctype_upper($char)) {
                    $m = ord($char)-65;
                    // echo ($m**$e)%$n."  ";
                    $enc[] = ($m**$e)%$n;
                    // openssl_public_encrypt($m,$enc_value,$public_key);
                    // $enc[] = $enc_value;
                    // $enc[] = $this->encrypt_decrypt('encrypt',$m,$public_key);
                }
                else if(ctype_lower($char)) {
                    $m = ord($char)-97;
                    $enc[] = ($m**$e)%$n;
                    // echo ($m**$e)%$n."  ";
                    // $enc[] = gmp_mod(((int)$m ** (int)$e),(int)$n);
                    // openssl_public_encrypt($m,$enc_value,$public_key);
                    // $enc[] = $enc_value;
                    // $enc[] = $this->encrypt_decrypt('encrypt',$m,$public_key);
                    // $enc[] = $m;
                }
                else if(ctype_space($char)) {
                    $enc[] = 400;
                }
            }

            $output = [
                "P" => $p,
                "Q" => $q,
                "message" => $str,
                "rsa_modulus_n" => $n,
                "eulers_toitent_r" => $r,
                "e" => $e,
                "private_key" => "($d,$n)",
                "public_key" => "($e,$n)",
                "encrypted_msg" => $enc
            ];
        }

        header('Content-Type: application/json');
        return json_encode( $output );
    }
    
    public function decrypt($a, $b, $text) {

        // smaller
        $p = $a > $b ? $b: $a;
        // larger
        $q = $a > $b ? $a: $b;

        $output = array();

        if(!$this->primeCheck($p) || !$this->primeCheck($q)) {
            $output[] = "---- P & Q should be Prime Numbers ----";
        }
        else if(abs($p-$q)<5) {
            $output[] = "---- Difference between numbers should be greater than 5 ----";
        }
        else {
            
            // RSA Modulus
            $n = $p * $q;
            // Eulers Toitent
            $r = ($p-1)*($q-1);

            $e = $this->e_value($r);
            $d = $this->multiplicative_inverse($e,$r);
            $values = explode(',', $text);

            // remove non numeric values
            $values = array_filter($values,function($var) {
                return(is_numeric($var));
            });

            // indexing values
            $values = array_values($values);

            $public_key = [$e,$n];
            $private_key = [$d,$n];
            
            $dec_msg = '';
            $m = 0;
            foreach ($values as $val) {
                if($val==400) {
                    $dec_msg = $dec_msg.' ';
                }
                else {
                    $m = ((int)$val ** $d )%$n;
                    $m+=65;
                    $dec_msg = $dec_msg.chr($m);
                }
            }

            $output = [
                "P" => $p,
                "Q" => $q,
                "Values" => $values,
                "rsa_modulus_n" => $n,
                "eulers_toitent_r" => $r,
                "e" => $e,
                "private_key" => "($d,$n)",
                "public_key" => "($e,$n)",
                "decrypted_msg" => $dec_msg
            ];
        }

        header('Content-Type: application/json');
        return json_encode( $output );
    }

    protected function primeCheck($num) {
        if($num==2){
            return TRUE;
        }
        elseif ($num<2 || $num%2==0) {
            return FALSE;
        }
        elseif ($num>2) {
            for ($i=2; $i < $num; $i++) { 
                if($num%$i==0) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    protected function euclid_gcd($e,$r) {
        if ($e == 0)
            return $r;
        return $this->euclid_gcd($r % $e, $e);
    }
    
    protected function e_value($r) {
        // FINDS THE HIGHEST POSSIBLE VALUE OF 'e' BETWEEN 1 and 10 THAT MAKES (e,r) COPRIME
        $e = 0;
        for ($i=1; $i < 10 ; $i++) { 
            if($this->euclid_gcd($i,$r) === 1) {
                $e=$i;
            }
        }
        return $e;
    }

    protected function extended_euclid_gcd($a, $b) {
        if($a%$b == 0) {
            // echo "b=$b, s=0, t=1<br>";
            return [$b,0,1];
        }
        else {
            [$gcd, $s, $t] = $this->extended_euclid_gcd($b,$a%$b);
            $s = $s - (floor($a/$b) * $t);
            // echo "gcd=$gcd, t=$t, s=$s<br>";
            return [$gcd,$t,$s];
        }
        // verify using as + bt = gcd(a,b)
    }

    protected function multiplicative_inverse($e, $r) {

        [$gcd,$s,$t] = $this->extended_euclid_gcd($e,$r);
        if($gcd!=1)
            return 0;
        else {
            // if(s<0):
            //     print("s=%d. Since %d is less than 0, s = s(modr), i.e., s=%d."%(s,s,s%r))
            // elif(s>0):
            //     print("s=%d."%(s))
            // echo "s=$s, s%r = $s%$r = ".gmp_mod($s,$r);
            return gmp_strval(gmp_mod( (int)$s, (int)$r ));
        }
    }

    // NOT IN USE
    protected function encrypt_decrypt($action, $string, $key) {
        $output = false;
        $encrypt_method = "AES-128-CTR";
        $secret_iv = '1234567890123456';
        $iv = substr($secret_iv,0,16);
        if($action=='encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action=='decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }


}
