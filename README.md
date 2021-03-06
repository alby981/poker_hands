# PokerHands Test

## How to install and deploy?

Follow these steps to install and deploy the application:

- git clone https://github.com/alby981/poker_hands.git
- composer install
- npm install
- cp .env.example .env (change here your DB settings)
- php artisan key:generate
- Create an empty database for our application
- php artisan migrate (this creates all the tables needed)
- vhost dir needs to point to public folder 
- give full permission to folder "storage"
- give full permission to folder "public/uploads"

## How does the test works?

- "Poker Hands" is the page that shows the results, and the winners. 
You can see how the winner wins the hand VS the opponent hand. 

- "Upload Poker Hands" is the page that allows to upload the file and, at the same time, process the winners. 
At the moment it uploads the file as well in the "public" dir, mainly for testing purposes, and it process the winner at the same time. 
I could have done that at a different moment, but i just chose this approach for simplicity. 

- In order to Upload the file, you need to be logged in and, of course, you need to register yourself first. 

## Notes

### Slow uploading of file (around 1 minute for 1k Record)

I have done it in the clean way, using model instead of transactions with "raw" query.
This can be way faster, just adding a DB Transaction and a "raw" query. Nothing really complicated,
it's just a different approach. 
 
### Code

You will figure it out that, regards to code, I cheated :D. I found some code online that provide already a logic, i had to change a big chunk of it cause was overkill,
over engineered and some methods were not working at all (for instance the method "isStraight").
It's still too complex imho, and i would like to change it, but due to time i wanted to provide a solution as quickest as possible.
Of course i can explain how it works and the logic behind it, it's nothing really complicated. 
Tbh, i would like to do with bitwise comparisons that sounds to me the best solution, even in terms of performance, but 
is the less readable and, in that case, i had to do longer tests, so i preferred to follow a more "naive" approach.  
You find in the code something that it can be done differently, for instance in some for loops i use the "count". That's something i usually avoid,
because of performance. It's a small change to do, nothing really major, but i just wanted to pointed it out. :D 

### Framework Used

I used Laravel because it's a professional approach in order to write code following some of the best practices (MVC as in requirements). 

### Css / Inline

At the moment, due to time, i just set inline code and i didn't put too much effort into having a clean HTML / CSS. 
I can do it way better, of course, but i prefer, like i said before, to provide the solution as quick as possible. 
If it was an enterprise solution, i would have done way differently, using centralized (scss) and a better templating system. 

## Additional Notes

- If you find any issue with the deploy process, even though you shouldn't, I can provide a website of mine, that contain 
the full code and works already. I have a VPS with Linux, and everything is set up and working. 
Atm is offline, just for security purposes, but i can activate the code if / when you need it. :)

- I'm not doing any data consistency checks right now as i'm assuming that the file uploaded is correct everytime (as of requirements). 
This is something that i would do differently in an enterprise solution (for instance checking if i have 10 cards for each line, if there is something wrong
with the suits, values, etc).

Thanks for the opportunity in any case and enjoy it. :)
 



