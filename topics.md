#Outline of possible topics to cover

Not in any specific order. Topics for which at least some writing is done are marked with *.

* Intro * 
* Getting PHP * 
* Hello World * 
* Http * 
* Variables * 
* Arrays * 
* Functions * 
* Classes *
* Loading other files (require_once and / or using composer autoloader) - including namespaces *
* Databases (PDO with SQLite)
* Testing (PHPUnit)
* Static analysis (Psalm)
* Templating (e.g. twig)
* How to learn / do more with PHP after tutorial (including links to frameworks, official docs, php weekly / annotated etc)

## PHP Keywords
Full list of keywords from https://www.php.net/manual/en/reserved.keywords.php

Some keywords should be introduced by this tutorial (yes), some should be left out as not necessary
for a beginning PHP developer, and some should be assumed known from JS/TS or other languages. 

| Keyword                           | Introduce (yes/no/assume/?) |
| --------------------------------- | ---------------------- |
| __halt_compiler()      | No               |
| abstract      | No               |
| and      | No               |
| array()      | No               |
| as      | Yes               |
| break      | ?               |
| callable (as of PHP 5.4)      | ?               |
| case      | No               |
| catch      | Yes              |
| class      | Yes               |
| clone      | ?               |
| const      | Yes               |
| continue      | ?               |
| declare      | Yes               |
| default      | ?               |
| die()      | ?               |
| do      | No               |
| echo      | Yes               |
| else      | assume               |
| elseif      | no               |
| empty()      | ?               |
| enddeclare      | no               |
| endfor      | no               |
| endforeach      | no               |
| endif      | no                |
| endswitch      | no               |
| endwhile      | no               |
| eval()      | no               |
| exit()      | no               |
| extends      | Yes (?)               |
| final      | Yes               |
| finally (as of PHP 5.5)      | no               |
| for      | no               |
| foreach      | yes               |
| function      | yes               |
| global      | no               |
| goto (as of PHP 5.3)      | no               |
| if      | assume               |
| implements      | yes               |
| include      | no               |
| include_once      | no               |
| instanceof      | no               |
| insteadof (as of PHP 5.4)      | no               |
| interface      | yes               |
| isset()      |  no              |
| list()      |  no              |
| namespace (as of PHP 5.3)      |  yes              |
| new      |  yes              |
| or      |   no             |
| print      |  no              |
| private      |  yes              |
| protected      |  no              |
| public      |   yes             |
| require      |  no              |
| require_once      |  yes (at least to require vendor/autoload.php )              |
| return      |   assume             |
| static      |   yes             |
| switch      |  no / assume              |
| throw      |   yes             |
| trait (as of PHP 5.4)      |   no             |
| try      |   yes             |
| unset()      |   no             |
| use      |   ?             |
| var      |   no             |
| while      |  no              |
| xor      |  no              |
| yield (as of PHP 5.5)      |   no             |
| yield from (as of PHP 7.0)      |   no             |
