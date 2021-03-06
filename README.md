# Model Worlds #
> A PHP-based recreation of [Model Worlds](http://ModelWorlds.net).

## History ##
[Model Worlds](http://steamcommunity.com/app/332310/discussions/0/523890046877780804/) is a Steam Workshop-inspired site envisioned by Dalí Llama as a way to share brick-built [LEGO Digital Designer](http://ldd.lego.com) models compatible with the [LEGO&reg; Worlds](http://store.steampowered.com/app/332310) video game by TT Games.

I had the privilege of learning Dalí's plans for the site and motivation behind it, in addition to providing moral and technical support and helping out with future site features. In the course of our many discussions, Dalí mentioned creating a brand new site that would be even better than the current one. However, because he was afraid of the plans falling through, I secretly set out on recreating the current Model Worlds site, both front-end and back-end (though I also did it for fun and to gain some experience in PHP). In a mere three days, I had completely recreated the site in a slightly-modified and responsive form and built an entire user registration/log in/log out system based on PHP and MySQL. I spent the remainder of the week filling in intentionally skipped areas and fixing various bugs in the system, in addition to implementing a contact form and password reset utility.

Suddenly, all of Dalí's activity stopped, and nobody was able to contact him. After three months of no activity, Dalí returned, [announcing](http://steamcommunity.com/app/332310/discussions/0/523890046877780804/#c481115363872354902) that the new Model Worlds site was canceled and Model Worlds itself was over.

When the announcement was made, I had long stopped development on my recreation due to having hit a tricky bug and being overwhelmed with college homework. However, I had no desire to continue development and run my own version of Model Worlds, nor did I wish to keep the source code to myself, as others might benefit from it and I could use it as an example of PHP work I have done. Thus I open-sourced my recreation for all to see.

## Support ##
In order to be clear, I will not provide support for any of the code present. I am releasing this in an incomplete state, and as such there are areas that are not fully completed, secured, or bug tested. Furthermore, I will not provide a live demo of the site to everyone to view. If you would like to run the code, be sure to check out the Requirements section below.

## Requirements ##
* PHP >= 5.4 (developed and tested on 5.4.23, 5.5.9, and 5.6.11)
* MySQL >= 5.6.0 (use the appropriate SQL script for your version)
* [password_compat](https://github.com/ircmaxell/password_compat), saved to `lib/password.php`
* [Mustache.php](https://github.com/bobthecow/mustache.php), saved to `lib/Mustache/**`

## License ##
[MIT](LICENSE)

2015 Caleb Ely
