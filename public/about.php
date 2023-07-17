<?php 
declare(strict_types = 1);
include "../src/bootstrap.php";

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "About";
$description = $title . " on Hiking RVer";

?>

<?php include APP_ROOT . "/public/includes/header.php" ?>

<div class="container">

    <div class="flag text-center">
        <h1>About Me</h1>
        <!-- <p class="lead"> Some things about the Hiking RVer </p> -->
        <hr>
        <br>
    </div>

    <br>
			
    <section class="my-story">

        <div class="about-me-box text-center">

            <div class="profile text-center" style="width: 50%;">
                <img src="images/ed.jpg" alt="Photo of Hiking-RVer" class="img img-rounded" width="250">
                <!-- <h2>Hello</h2> -->
                <br><br>
                <h6>Welcome to my website. I had fun developing it. I consider myself a full-timer, which means I live and travel full-time in my RV. I'm sure you can tell that I enjoy hiking as well. Below I will introduce you to some of my skills and hobbies.  I hope you enjoy my website!</h6>
            </div>
            <br>

            <hr>
            <div class="skills-container">

                <div class="skills-hobbies text-center">
                    <h2>Skills and Hobbies</h2>
                </div>

                
                
                <br><br>
                <div class="skills row row-cols-2">
                    <div class="col-lg-6">
                        <img class="hiker-image" src="images/hiker.png" alt="hiker image" style="width: 100px;">
                        <h3 class="skills-heading-left">Hiking</h3>
                        <p class="hiking-description">I really enjoy hiking a lot.  It's challenging, yet rewarding.  Spending time outdoors is great for the mind and body. The physical workout can be easy, moderate or difficult.  It doesn't matter whether I'm hiking to a waterfall, a scenic view, or just a walk through the woods enjoying nature. Love it!</p>
                        <p class="attribution"><span class="note">Note</span>: Hiking icon made by <a href="https://www.flaticon.com/authors/pongsakornred" title="pongsakornRed">pongsakornRed</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a></p>
                    </div>
                
                    <div class="col-lg-6">
                        <img class="camper-image" src="images/camping.png" alt="camper image" style="width: 100px;">
                        <h3 class="skills-heading-right">RVing</h3>
                        <p class="rving-description">Decades ago, while in the Navy in San Diego, I met a couple who lived and travelled in their RV.  This was 1979.  I decided then that one day I would be a full-timer (living full time in an RV). April 2017 I did just that. I've been to a lot of cool places and met a lot of great people.  I'm so glad I met that couple so long ago, who inspired my current lifestyle!</p>
                        <p class="attribution"><span class="note">Note</span>: Camper icon made by <a href="https://www.flaticon.com/free-icon/camping_2797887?term=camper&page=2&position=30" title="iconixar">iconixar</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a></p>
                    </div>
                </div>

                <div class="skills row row-cols-2">
                    <div class="col-lg-6">
                        <img class="skills-image football-image" src="images/football.png" alt="footballimage" style="width: 100px;">
                        <h3 class="skills-heading-left">Football</h3>
                        <p class="patriots-description">Growing up near Boston, I am a huge New England Patriots fan! I was a fan as long as I can remember. There were many disappointing seasons along the way. I started going to at least one game every year, from 1982 when I got out of the Navy, until 2017 when I hit the road in my RV. Ever since the Krafts bought the team in the mid 90's, I have been blessed to experience (as a fan) 6 Super Bowl Victories! What an incredible Dynasty! What an incredible journey!</p>
                        <p class="attribution"><span class="note">Note</span>: Football icon made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></p>
                    </div>
                
                    <div class="col-lg-6">
                        <img class="skills-image beer-image" src="images/beer.png" alt="beer image" style="width: 100px;">
                        <h3 class="skills-heading-right">Beer</h3>
                        <p class="craft-beer-description">What can I say, I enjoy the vast variety of modern craft beers, lagers, ales, stouts, IPA's, porters, etc. I like sampling a variety flight at a local microbrewery, or while having appetizers at a brew pub, or while relaxing with family or friends by a firepit. The craft beers of today are so full of flavor.  I'm getting thirsty just thinking about it.</p>
                        <p class="attribution"><span class="note">Note</span>: Beer icon made by <a href="" title="photo3idea_studio">photo3idea_studio</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></p>
                    </div>
                </div>

                <div class="skills row row-cols-2">
                    <div class="col-lg-6">
                        <img class="skills-image website-image" src="images/web-development.png" alt="website development image" style="width: 100px;">
                        <h3 class="skills-heading-left">Websites</h3>
                        <p class="website-development-description">I have been learning how to develop websites. This website is about my hiking and RVing adventures. I built it from scratch using HTML, CSS, JavaScript and Bootstrap.  In the future I hope to put together a portfolio of different websites I've built myself.  I look forward to sharing them with you.</p>
                        <p class="attribution"><span class="note">Note</span>: Website icon made by <a href="https://www.flaticon.com/authors/nhor-phai" title="Nhor Phai">Nhor Phai</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a></p>
                    </div>
                
                    <div class="col-lg-6">
                        <img class="skills-image fireman-image" src="images/fireman.png" alt="fireman image" style="width: 100px;">
                        <h3 class="skills-heading-right">Firefighting</h3>
                        <p class="firefighting-description">Working as a firefighter for the city of Cranston, RI, was the best career I ever could have hoped for. Ever since learning firefighting in the Navy, I knew this was the job for me. The job is highly challenging and can be very stressful at times. I am proud of the fact that I was able to help so many people in their time of need. I miss the job a lot now that I'm retired, especially the comraderie of my fellow firefighters!</p>
                        <p class="attribution"><span class="note">Note</span>: Firefighter icon made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a></p>
                    </div>
                </div>

                <div class="skills row row-cols-2">
                    <div class="col-lg-6">
                        <img class="skills-image truck-image" src="images/mover-truck.png" alt="truck image" style="width: 100px;">
                        <h3 class="skills-heading-left">Trucks</h3>
                        <p class="truck-driving-description">Truck driving is something I enjoy doing part time in my retirement. Truck drivers deliver all the products we as consumers use every day. It doesn't matter if I'm driving a tractor trailer across the region, or making dozens of deliveries per day locally. I love the freedom of working out on the road.</p>
                        <p class="attribution"><span class="note">Note</span>: Truck icon made by <a href="http://www.freepik.com/" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a></p>
                    </div>
                
                    <div class="col-lg-6">
                        <img class="skills-image stocks-image" src="images/technical.png" alt="stocks image" style="width: 100px;">
                        <h3 class="skills-heading-right">Stocks</h3>
                        <p class="stock-trading-description">Following the stock market has always been an interest of mine.  Day trading is something I have been working on learning. I would love to get hired as a Proprietary Day Trader someday.  Preserving capital, controlling the downside risk, holding onto profitable trades, being disciplined, taking all stops, learning from my mistakes, study the charts and try to determine the price action, then take any trades that meet my criteria. These are a few of the things needed to be a successful day trader. </p>
                        <p class="attribution"><span class="note">Note</span>: Stocks icon made by <a href="https://www.flaticon.com/authors/becris" title="Becris">Becris</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a></p>
                    </div>
                </div>

            </div>
        </div>
							
    </section>
    
</div>
		

<?php include APP_ROOT . "/public/includes/footer.php" ?>




