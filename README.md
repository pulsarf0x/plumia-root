
# Plumia Root

I apologize for my bad english. If your super language skill detect some faults, you can insult me at pascal@plumia.net. 
You also can tell me where the language faults kindly.
Anyway, I like both of these.

## Installation
First, you need to clone this repo.
After cloned, you need to define database id into config/database.php

All the routing system is located into config/routes.php. You maybe noticed that the two config files are only in PHP. 
I'm going to explain you this later here.

## Thinking

In fact, you don't need to edit kernel classes but unlike Symfony or others framework, 
you can edit it without erase your changes after composer update. If you want.
Before take some torches and forks, you have to know that I love Symfony and Laravel so much and most of my app projects are on these.
This humble framework can help you to build simple things like landing websites with contact form or blogs. 
I'm developping this to train my PHP skills to make something strong and simple in full PHP. Without YAML, XML or something else.

## Secure

All default requests are made with prepared PDO requests to avoid some SQL injection. It's not perfect but I did my best.
If you noticed some potentials faults, feel free to let me know with an issue.

## Helpers

I made some helpers to increase developpment speed. Once again, feel free to add some functions that can increase your dev style speed.