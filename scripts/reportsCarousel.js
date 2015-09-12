//this variable will control which project and description is going to be shown
var projects = 1;


//here goes the JQuery code, which makes the carousels and connect both
//this code use the library JCarousel and was got from http://sorgalla.com/jcarousel/
(function($) {
    // This is the connector function.
    // It connects one item from the navigation carousel to one item from the
    // stage carousel.
    // The default behaviour is, to connect items with the same index from both
    // carousels. This might _not_ work with circular carousels!
    var connector = function(itemNavigation, carouselStage) {
        return carouselStage.jcarousel('items').eq(itemNavigation.index());
    };

    $(function() {
        // Setup the carousels. Adjust the options for both carousels here.
        var carouselStage      = $('.carousel-stage').jcarousel();
        var carouselNavigation = $('.carousel-navigation').jcarousel();

        // We loop through the items of the navigation carousel and set it up
        // as a control for an item from the stage carousel.
        carouselNavigation.jcarousel('items').each(function() {
            var item = $(this);

            // This is where we actually connect to items.
            var target = connector(item, carouselStage);

            item
                .on('jcarouselcontrol:active', function() {
                    carouselNavigation.jcarousel('scrollIntoView', this);
                    item.addClass('active');
                })
                .on('jcarouselcontrol:inactive', function() {
                    item.removeClass('active');
                })
                .jcarouselControl({
                    target: target,
                    carousel: carouselStage
                });
        });

        // Setup controls for the stage carousel
        $('.prev-stage')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.next-stage')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });

        // Setup controls for the navigation carousel
        $('.prev-navigation')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.next-navigation')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
    });
})(jQuery);

// JavaScript Document
//This function will control the project shown when the user click on the arrows.
function changeDescription(direction){
		
		if(direction == 'left'){
			if(projects == 1)
				projects = 9;
			else
				projects--;
		}
		else if(direction == 'right'){
			if(projects == 9)
				projects = 1;
			else
				projects++;
		}
		
		description();
}

//This function will control the project shown when the user click on the project in the second carousel.
function changeDescriptionImage(number){
		
		projects = number;
		
		description();
}

//This function will write all projects descriptions
function description(){
	
	
		if (projects == 1){
			document.getElementById("textDescription2").innerHTML = "First Adobe Illustrator project made for the \"Advanced Survey of Computer Art Applications\" class. The purpose of the project was making a landscape using the tools and skills learned during classes. The project shows a famous bridge, called Juscelino Kubitschek Bridge, which crosses lake Paranoa in Brasilia - Brazil.";
			document.getElementById("textDescription1").innerHTML = "JK Bridge";
			document.getElementById("textDescription3").innerHTML = "";
			document.getElementById("textDescription4").innerHTML = "";
			
		}
		if (projects == 2){
			document.getElementById("textDescription2").innerHTML = "Adobe Illustrator project made for the \"Advanced Survey of Computer Art Applications\" class. The purpose of the project was making any art using the text tool features.";
			document.getElementById("textDescription1").innerHTML = "Grow Love";	
			document.getElementById("textDescription3").innerHTML = "";
			document.getElementById("textDescription4").innerHTML = "";
		}
		if (projects == 3){
			document.getElementById("textDescription2").innerHTML = "Maya project made for the \"Advanced Survey of Computer Art Applications\" class. The project's purpose was building a 3D environment applying what was learned about 3D modeling and lighting.";
			document.getElementById("textDescription1").innerHTML = "Chess Pieces";	
			document.getElementById("textDescription3").innerHTML = "";
			document.getElementById("textDescription4").innerHTML = "";
		}
		if (projects == 4){
			document.getElementById("textDescription2").innerHTML = "Processing project made for the \"Core Principles: Programming\" class. The project was about getting data from the internet, and make a visualisation form with them. It shows the population's growth during the years 2004, 2007, 2010, and 2013 through graphics. You can download it clicking below.";
			document.getElementById("textDescription1").innerHTML = "Data Visualisation";
			document.getElementById("textDescription3").href = "processing_projects/visu_windows.zip";
			document.getElementById("textDescription3").innerHTML = "Windows ";
			document.getElementById("textDescription4").href = "processing_projects/visu_linux.zip";
			document.getElementById("textDescription4").innerHTML = "Linux";
			
				
		}
		if (projects == 5){
			document.getElementById("textDescription2").innerHTML = "Processing game made as final project for the \"Core Principles: Programming\" class. The game is basically airplanes throwing fast foods and the player can't let them fall on the ground trying to shoot them. Each kind of fast food has a different score. After 5 lives, the score is recorded as well as the highest score. You can download it clicking below.";
			document.getElementById("textDescription1").innerHTML = "Fast Food War";
			document.getElementById("textDescription3").href = "processing_projects/game_windows.zip";
			document.getElementById("textDescription3").innerHTML = "Windows ";
			document.getElementById("textDescription4").href = "processing_projects/game_linux.zip";
			document.getElementById("textDescription4").innerHTML = "Linux";	
		}
		if (projects == 6){
			document.getElementById("textDescription2").innerHTML = "While learning JavaScript, this project was developed. It was the first project using HTML, CSS and JavaScrip. Dice Game is played by two players. The game ends when either player rolls two 1’s or when one player reaches a score of 50. The player with the higher score wins. ";
			document.getElementById("textDescription1").innerHTML = "Dice Game";
			document.getElementById("textDescription3").innerHTML = "Open the game";
			document.getElementById("textDescription3").href = "dice_game/diceGame.html";
			document.getElementById("textDescription4").innerHTML = "";
		}
		if (projects == 7){
			document.getElementById("textDescription2").innerHTML = "This project was developed in Processing and its purpose was, applying programming skills learned during the class \"Core Principles: Programming\", draw a complex Pattern. It represents a heart using different shapes. ";
			document.getElementById("textDescription1").innerHTML = "Complex Pattern";
			document.getElementById("textDescription3").innerHTML = "";
			document.getElementById("textDescription4").innerHTML = "";
		}
		if (projects == 8){
			document.getElementById("textDescription2").innerHTML = "First of All, hover the mouse over the image. It was made during the class \"Core Principles: Programming\" and the main idea was making a interactive time-based pattern. My idea was based on Christmas and Pop Art. ";
			document.getElementById("textDescription1").innerHTML = "Interactive Time-Based Pattern";
			document.getElementById("textDescription3").innerHTML = "";
			document.getElementById("textDescription4").innerHTML = "";
		}
		if (projects == 9){
			document.getElementById("textDescription2").innerHTML = "First Adobe After Effects project made for the \"Advanced Survey of Computer Art Applications\" class. The character walks through the Calçada de Ipanema, which is a famous sidewalk in Rio de Janeiro. While he walks, the background changes showing some Brazil sights. ";
			document.getElementById("textDescription1").innerHTML = "Animation";
			document.getElementById("textDescription3").innerHTML = "";
			document.getElementById("textDescription4").innerHTML = "";
		}
	
	
	} 