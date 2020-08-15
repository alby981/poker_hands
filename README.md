How to install and deploy?

git clone https://github.com/alby981/poker_hands.git
composer install
npm install
cp .env.example .env
php artisan key:generate
Create an empty database for our application
php artisan migrate
vhost dir needs to point to public 
give full permission to folder "storage"
give full permission to folder "public/uploads"


How does the test works?
- Poker Hands is the page that shows the results, and the winners. 
You can see how the winner wins the hand VS the opponent hand. 
- Upload Poker Hands is the page that allows to upload the file and, at the same time, 
process the winners. 
At the moment it uploads the file as well, for "testing" purposes, and it process the winner at the same time. 
I could have done that at a different moment, but i just chose this approach for simplicity. 
- In order to Upload the file, you need to be logged in and, of course, you need to register yourself first. 

notes
- slow loading of file...
because i have done it in the clean way, using model instead of transactions with "raw" query. 
- code
I cheated a bit :D. I found some code online that provide already a logic, i had to changed it cause was overkill,
and some methods were not working at all.
It's still too complex, and i would like to change it, but due to time i wanted to provide a solution as quick as possible,
but, of course, i can explain how it works... it's nothing complicated. 
- Framework
i used Laravel because it's a clean and professional approach for writing code in a good way (MVC). 
- Css / Inline
At the moment, due to time, i just set inline code and i didn't put much effort into having a clean HTML. 
I can do it way better, of course, but i prefer, like i said before, to provide the solution as quickest as possible. 
If it was an enterprise solution, i would have done way differently, using centralized (scss) and a better templating. 

