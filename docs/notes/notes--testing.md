#Test Strategy:
## Tasks
TODO: Install Codeception

TODO: PHPUnit

TODO: Continuous integration (try Jetbrains)

TODO: I need to do a comparison of JS testing frameworks, and look at Jeffrey's testing videos.

## Task results
* I'm going to use Jasmin for the JS test as that's what the vue.js site uses in it's example.


I want to test as much as I can whilst still being able to move forward as quickly as possible.
The things I want to test are

##Front end
* Data is printed in the table
* Data is imported correctly
* Data is parsed correctly
* Certain columns can be sorted
* Certain columns cannot be sorted
* Certain fields e.g. create a filter
* If data is filtered, only the filtered data is shown

## Backend
* Data picks up the feed request & serve the correct data
* Data pulls correctly from the database
* Data can ...

## Strategy
### Unit Tests
* don't test Eloquent functionality

### Functional Tests
I want functional tests to cover all aspects of the system that a user (me) may face.
* Register
* Login in
* Log out
* log into the halifax site
* Select correct account
* Get
  * balance
  * available balance
  * outstanding transactions
  * go through each transaction & get the transaction details
* logout
* import data to backend
* add data to the db
* update data on frontendS
* send notification if done offline

## Prediction service
tba
 
## Tools
###PHP
I think that for PHP I will once again be using Codeception.
It is a tool I have used before and considering I also need to test the frontend now, I think it may be best to keep this part quite familiar,

### Javascript/Vue
The only framework I've has with JS is with Jasmin. As I understand it - Vue has a good framework.

## Order of play
1. Brush up on Codecept
2. Look up TeamAccess CI software

