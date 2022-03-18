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
            $str = str_split(strtoupper($text));

            $public_key = [$e,$n];
            $private_key = [$d,$n];
            
            $enc = array();
            $m = 0;
            foreach ($str as $key => $char) {
                if(ctype_upper($char)) {
                    $m = ord($char)-65;
                    $enc[] = pow($m, $e)%$n;
                }
                else if(ctype_lower($char)) {
                    $m = ord($char)-97;
                    $enc[] = pow($m, $e)%$n;
                }
                else if(ctype_space($char))
                    $enc[] = 400;
            }

            $output[] = [
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

    protected function extended_euclid_gcd($a, $b) {
        if($a%$b==0)
            return [$b,0,1];
        else {
            [$gcd, $s, $t] = $this->extended_euclid_gcd($b,$a%$b);
            $s = $s-(floor($a/$b) * $t);
            return [$gcd,$t,$s];
        }
    }

    protected function multiplicative_inverse($e, $r) {

        // TODO ------ getting error
        [$gcd,$s,$t] = $this->extended_euclid_gcd($e,$r);
        if($gcd!=1)
            return 0;
        else
            // if(s<0):
            //     print("s=%d. Since %d is less than 0, s = s(modr), i.e., s=%d."%(s,s,s%r))
            // elif(s>0):
            //     print("s=%d."%(s))
            return $s%$r;
    }
    

}
