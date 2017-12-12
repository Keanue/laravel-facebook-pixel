<?php

namespace Keanue\LaravelFacebookPixel;

class LaravelFacebookPixel
{
    /**
     * @param \Keanue\LaravelFacebookPixel\config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function headContent()
    {
        return "<!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
          n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
              document,'script','https://connect.facebook.net/en_US/fbevents.js');
              fbq('init', '" . $this->config['facebook_pixel_id'] . "', {
              });
              fbq('track', 'PageView');
              </script>
              <noscript><img height='1' width='1' style='display:none'
              src='https://www.facebook.com/tr?id=" . $this->config['facebook_pixel_id'] . "&ev=PageView&noscript=1'
              /></noscript>
              <!-- DO NOT MODIFY -->
              <!-- End Facebook Pixel Code -->";
    }

    public function bodyContent()
    {
        $facebookPixelSqs = session()->pull('facebookPixelSqs', []);
        $pixelCode        = "";

        if (count($facebookPixelSqs) > 0) {
            foreach ($facebookPixelSqs as $key => $facebookPixel) {
                $pixelCode .= "fbq('track', '" . $facebookPixel["name"] . "', " . json_encode($facebookPixel["parameters"]) . ");";
            };
            session()->forget('facebookPixelSqs');
            return "<script>" . $pixelCode . "</script>";
        }
        return "";
    }

    public function createEvent($eventName, $parameters = [])
    {
        $facebookPixelSqs = session('facebookPixelSqs');
        $facebookPixelSqs = (count($facebookPixelSqs) == 0) ? [] : $facebookPixelSqs;

        $facebookPixel = [
            "name"       => $eventName,
            "parameters" => $parameters,
        ];

        array_push($facebookPixelSqs, $facebookPixel);

        session(['facebookPixelSqs' => $facebookPixelSqs]);
    }
}
