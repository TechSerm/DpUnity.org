<?php

namespace App\Services\Theme;

use PhpParser\Node\Expr\Cast\Object_;

class HeaderService
{
    public function get()
    {
        $headers = (Object)[
            (Object)[
                'title' => 'হোম', 
                'url' => route('home.index')
            ],
            (Object)[
                'title' => 'আমাদের সম্পর্কে', 
                'url' => route('about_us')
            ],
            (Object)[
                'title' => 'সদস্য নিবন্ধন', 
                'url' => route('members.create')
            ],
            (Object)[
                'title' => 'সদস্যের তালিকা', 
                'url' => route('members.index')
            ],
            (Object)[
                'title' => 'জমার তালিকা', 
                'url' => route('diposite')
            ],
        ];

        return $headers;
    }
}