<?php

namespace App\Controllers;

class RsaFunction extends BaseController
{
    public function index() {
        return view('rsa_function');
        // $res = array(
        //     'name' => 'ars',
        //     'name2' => 'shaikh',
        //     'city' => 'ahmedabad'
        // );
        // header('Content-Type: application/json');
        // return json_encode( $res );
    }
    
    public function encrypt($a, $b, $text) {
        
        // smaller
        $p = $a > $b ? $b: $a;
        // larger
        $q = $a > $b ? $a: $b;

        $output = array();

        if(!$this->primeCheck($p) || !$this->primeCheck($q)) {
            $output[] = "---- Not Prime Number ----";
        }
        else if(abs($p-$q)<5) {
            $output[] = "---- Choose different Numbers ----";
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
            foreach ($str as $key => $char) {
                if(ctype_upper($char)) {
                    $m = ord($char)-65;
                    // echo "m = $m";
                    $enc[] = $m;
                    // $enc[] = gmp_mod(((int)$m ** (int)$e),(int)$n);
                }
                else if(ctype_lower($char)) {
                    $m = ord($char)-97;
                    // echo "m = $m";
                    $enc[] = $m;
                    // $enc[] = gmp_mod(((int)$m ** (int)$e),(int)$n);
                    // $enc[] = ($m**$e)%$n;
                }
                else if(ctype_space($char)) {
                    $enc[] = 400;
                }
            }

            $output[] = [
                "P" => $p,
                "Q" => $q,
                "Message" => $str,
                "RSA modulus(n)" => $n,
                "Eulers Toitent(r)" => $r,
                "e" => $e,
                "Private Key" => "($d,$n)",
                "Public Key" => "($e,$n)",
                "Encrypted Values" => $enc
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
            $output[] = "---- Not Prime Number ----";
        }
        else if(abs($p-$q)<5) {
            $output[] = "---- Choose different Numbers ----";
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

            $public_key = [$e,$n];
            $private_key = [$d,$n];
            
            $dec_msg = '';
            $m = 0;
            foreach ($values as $key => $val) {
                if($val==400) {
                    $dec_msg = $dec_msg.' ';
                }
                else {
                    $dec_msg = $dec_msg.chr($val+65);
                }
            }

            $output[] = [
                "P" => $p,
                "Q" => $q,
                "Values" => $values,
                "RSA modulus(n)" => $n,
                "Eulers Toitent(r)" => $r,
                "e" => $e,
                "Private Key" => "($d,$n)",
                "Public Key" => "($e,$n)",
                "Decrypted_message" => $dec_msg
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
        // FINDS THE HIGHEST POSSIBLE VALUE OF 'e' BETWEEN 1 and 1000 THAT MAKES (e,r) COPRIME
        $e = 0;
        for ($i=1; $i < 1000 ; $i++) { 
            if($this->euclid_gcd($i,$r) === 1)
                $e=$i;
        }
        return $e;
    }

    public function extended_euclid_gcd($a, $b) {
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

    public function multiplicative_inverse($e, $r) {

        [$gcd,$s,$t] = $this->extended_euclid_gcd($e,$r);
        if($gcd!=1)
            return 0;
        else {
            // if(s<0):
            //     print("s=%d. Since %d is less than 0, s = s(modr), i.e., s=%d."%(s,s,s%r))
            // elif(s>0):
            //     print("s=%d."%(s))
            // echo "s=$s, s%r = $s%$r = ".gmp_mod($s,$r);
            // die(gmp_strval(gmp_mod($s,$r))); //it is s%r
            return gmp_strval(gmp_mod( (int)$s, (int)$r ));
        }
    }


}
