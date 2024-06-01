<?php
include('connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attendance Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    
    <!-- Include Bootstrap and other stylesheets -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
   <style type="text/css">
 body {
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }
           .intro-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .intro-img {
            max-width: 50%;
            animation: fadeOut 3s ease-in-out forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; display: none; }
        }
        .navbar {
            background-color: #f8f9fa;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #dee2e6;
        }
        
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh; /* Center vertically on the viewport */
        }

        .center-image {
            max-width: 100%; /* Increase the image size further */
            height: 400px; /* Maintain aspect ratio */
        }

        .navbar-toggler-icon {
            background: none;
            border: none;
        }

        .navbar a {
            color: #333;
            text-decoration: none;
            padding: 10px;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #007bff;
        }

        .animated-link {
            position: relative;
            overflow: hidden;
        }

        .animated-link::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #007bff;
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease-in-out;
        }

        .animated-link:hover::before {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

       .user-info {
        font-weight: bold;
        color: blue; /* Add this line to change the color to blue */
    }

        .menu-icon {
            display: block;
            width: 25px;
            height: 2px;
            margin: 4px auto;
            background-color: #333;
        }
        
    </style>
</head>
<body>
     <div id="intro-image" class="intro-image">
        <img src="assets/img/logo.gif" alt="Intro Image" class="intro-img">
    </div>

<header>
    <h1>Student</h1>
    <nav class="navbar navbar-expand-md">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <span class="menu-icon"></span>
                <span class="menu-icon"></span>
                <span class="menu-icon"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Navigation links -->
                <li class="nav-item"><a class="nav-link animated-link" href="studenthome.php">Home</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="studentindex.php">Cummulative Attendence</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="studentreport.php">My Report</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="studentaccount.php">Student Account</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="student_percentage.php">Daily Overview</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="user-info">
            <?php
            // Replace '$_SESSION['username']' with the actual session variable that holds the user's name
            if(isset($_SESSION['username'])) {
                $loggedInUsername = $_SESSION['username'];
                echo strtoupper($loggedInUsername); // Display the username in capital letters
            }
             else {
            
            echo '<script>window.location.href = "attindex.php";</script>';
        }
            ?>
        </div>
    </nav>
</header>
 <div class="container-fluid text-center">
        <div class="row">
            <div class="col-12">
<div class="center-container">
        <img src="assets/img/atte.png" alt="Image" class="center-image">
    </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function () {
            var introImage = document.getElementById("intro-image");
            if (introImage) {
                introImage.remove();
            }
        }, 3000);
    </script>

    <script>
/**
 * Ribbons Class File.
 * Creates low-poly ribbons background effect inside a target container.
 */
;(function(name, factory) {
  if (typeof window === 'object') {
    window[name] = factory()
  }
})('Ribbons', function() {
  var _w = window,
    _b = document.body,
    _d = document.documentElement

  // random helper
  var random = function() {
    if (arguments.length === 1) {
      // only 1 argument
      if (Array.isArray(arguments[0])) {
        // extract index from array
        var index = Math.round(random(0, arguments[0].length - 1))
        return arguments[0][index]
      }
      return random(0, arguments[0]) // assume numeric
    } else if (arguments.length === 2) {
      // two arguments range
      return Math.random() * (arguments[1] - arguments[0]) + arguments[0]
    } else if (arguments.length === 4) {
      //

      var array = [arguments[0], arguments[1], arguments[2], arguments[3]]
      return array[Math.floor(Math.random() * array.length)]
      //return console.log(item)
    }
    return 0 // default
  }

  // screen helper
  var screenInfo = function(e) {
    var width = Math.max(
        0,
        _w.innerWidth || _d.clientWidth || _b.clientWidth || 0
      ),
      height = Math.max(
        0,
        _w.innerHeight || _d.clientHeight || _b.clientHeight || 0
      ),
      scrollx =
        Math.max(0, _w.pageXOffset || _d.scrollLeft || _b.scrollLeft || 0) -
        (_d.clientLeft || 0),
      scrolly =
        Math.max(0, _w.pageYOffset || _d.scrollTop || _b.scrollTop || 0) -
        (_d.clientTop || 0)

    return {
      width: width,
      height: height,
      ratio: width / height,
      centerx: width / 2,
      centery: height / 2,
      scrollx: scrollx,
      scrolly: scrolly
    }
  }

  // mouse/input helper
  var mouseInfo = function(e) {
    var screen = screenInfo(e),
      mousex = e ? Math.max(0, e.pageX || e.clientX || 0) : 0,
      mousey = e ? Math.max(0, e.pageY || e.clientY || 0) : 0

    return {
      mousex: mousex,
      mousey: mousey,
      centerx: mousex - screen.width / 2,
      centery: mousey - screen.height / 2
    }
  }

  // point object
  var Point = function(x, y) {
    this.x = 0
    this.y = 0
    this.set(x, y)
  }
  Point.prototype = {
    constructor: Point,

    set: function(x, y) {
      this.x = x || 0
      this.y = y || 0
    },
    copy: function(point) {
      this.x = point.x || 0
      this.y = point.y || 0
      return this
    },
    multiply: function(x, y) {
      this.x *= x || 1
      this.y *= y || 1
      return this
    },
    divide: function(x, y) {
      this.x /= x || 1
      this.y /= y || 1
      return this
    },
    add: function(x, y) {
      this.x += x || 0
      this.y += y || 0
      return this
    },
    subtract: function(x, y) {
      this.x -= x || 0
      this.y -= y || 0
      return this
    },
    clampX: function(min, max) {
      this.x = Math.max(min, Math.min(this.x, max))
      return this
    },
    clampY: function(min, max) {
      this.y = Math.max(min, Math.min(this.y, max))
      return this
    },
    flipX: function() {
      this.x *= -1
      return this
    },
    flipY: function() {
      this.y *= -1
      return this
    }
  }

  // class constructor
  var Factory = function(options) {
    this._canvas = null
    this._context = null
    this._sto = null
    this._width = 0
    this._height = 0
    this._scroll = 0
    this._ribbons = []
    this._options = {
      // ribbon color HSL saturation amount
      colorSaturation: '80%',
      // ribbon color HSL brightness amount
      colorBrightness: '60%',
      // ribbon color opacity amount
      colorAlpha: 0.65,
      // how fast to cycle through colors in the HSL color space
      colorCycleSpeed: 6,
      // where to start from on the Y axis on each side (top|min, middle|center, bottom|max, random)
      verticalPosition: 'center',
      // how fast to get to the other side of the screen
      horizontalSpeed: 150,
      // how many ribbons to keep on screen at any given time
      ribbonCount: 3,
      // add stroke along with ribbon fill colors
      strokeSize: 0,
      // move ribbons vertically by a factor on page scroll
      parallaxAmount: -0.5,
      // add animation effect to each ribbon section over time
      animateSections: true
    }
    this._onDraw = this._onDraw.bind(this)
    this._onResize = this._onResize.bind(this)
    this._onScroll = this._onScroll.bind(this)
    this.setOptions(options)
    this.init()
  }

  // class prototype
  Factory.prototype = {
    constructor: Factory,

    // Set and merge local options
    setOptions: function(options) {
      if (typeof options === 'object') {
        for (var key in options) {
          if (options.hasOwnProperty(key)) {
            this._options[key] = options[key]
          }
        }
      }
    },

    // Initialize the ribbons effect
    init: function() {
      try {
        this._canvas = document.createElement('canvas')
        this._canvas.style['display'] = 'block'
        this._canvas.style['position'] = 'fixed'
        this._canvas.style['margin'] = '0'
        this._canvas.style['padding'] = '0'
        this._canvas.style['border'] = '0'
        this._canvas.style['outline'] = '0'
        this._canvas.style['left'] = '0'
        this._canvas.style['top'] = '0'
        this._canvas.style['width'] = '100%'
        this._canvas.style['height'] = '100%'
        this._canvas.style['z-index'] = '-1'
        this._onResize()

        this._context = this._canvas.getContext('2d')
        this._context.clearRect(0, 0, this._width, this._height)
        this._context.globalAlpha = this._options.colorAlpha

        window.addEventListener('resize', this._onResize)
        window.addEventListener('scroll', this._onScroll)
        document.body.appendChild(this._canvas)
      } catch (e) {
        console.warn('Canvas Context Error: ' + e.toString())
        return
      }
      this._onDraw()
    },

    // Create a new random ribbon and to the list
    addRibbon: function() {
      // movement data
      var dir = Math.round(random(1, 9)) > 5 ? 'right' : 'left',
        stop = 1000,
        hide = 200,
        min = 0 - hide,
        max = this._width + hide,
        movex = 0,
        movey = 0,
        startx = dir === 'right' ? min : max,
        starty = Math.round(random(0, this._height))

      // asjust starty based on options
      if (/^(top|min)$/i.test(this._options.verticalPosition)) {
        starty = 0 + hide
      } else if (/^(middle|center)$/i.test(this._options.verticalPosition)) {
        starty = this._height / 2
      } else if (/^(bottom|max)$/i.test(this._options.verticalPosition)) {
        starty = this._height - hide
      }

      // ribbon sections data
      var ribbon = [],
        point1 = new Point(startx, starty),
        point2 = new Point(startx, starty),
        point3 = null,
        color = Math.round(random(35, 35, 40, 40)),
        delay = 0

      // buils ribbon sections
      while (true) {
        if (stop <= 0) break
        stop--

        movex = Math.round(
          (Math.random() * 1 - 0.2) * this._options.horizontalSpeed
        )
        movey = Math.round((Math.random() * 1 - 0.5) * (this._height * 0.25))

        point3 = new Point()
        point3.copy(point2)

        if (dir === 'right') {
          point3.add(movex, movey)
          if (point2.x >= max) break
        } else if (dir === 'left') {
          point3.subtract(movex, movey)
          if (point2.x <= min) break
        }
        // point3.clampY( 0, this._height );
        //console.log(Math.round(random(1, 5)))
        ribbon.push({
          // single ribbon section
          point1: new Point(point1.x, point1.y),
          point2: new Point(point2.x, point2.y),
          point3: point3,
          color: color,
          delay: delay,
          dir: dir,
          alpha: 0,
          phase: 0
        })

        point1.copy(point2)
        point2.copy(point3)

        delay += 4
        //color += 1
        //console.log('colorCycleSpeed', color)
      }
      this._ribbons.push(ribbon)
    },

    // Draw single section
    _drawRibbonSection: function(section) {
      if (section) {
        if (section.phase >= 1 && section.alpha <= 0) {
          return true // done
        }
        if (section.delay <= 0) {
          section.phase += 0.02
          section.alpha = Math.sin(section.phase) * 1
          section.alpha = section.alpha <= 0 ? 0 : section.alpha
          section.alpha = section.alpha >= 1 ? 1 : section.alpha

          if (this._options.animateSections) {
            var mod = Math.sin(1 + section.phase * Math.PI / 2) * 0.1

            if (section.dir === 'right') {
              section.point1.add(mod, 0)
              section.point2.add(mod, 0)
              section.point3.add(mod, 0)
            } else {
              section.point1.subtract(mod, 0)
              section.point2.subtract(mod, 0)
              section.point3.subtract(mod, 0)
            }
            section.point1.add(0, mod)
            section.point2.add(0, mod)
            section.point3.add(0, mod)
          }
        } else {
          section.delay -= 0.5
        }
        //console.log('section.color', section.color)
        var s = this._options.colorSaturation,
          l = this._options.colorBrightness,
          c =
            'hsla(' +
            section.color +
            ', ' +
            s +
            ', ' +
            l +
            ', ' +
            section.alpha +
            ' )'

        this._context.save()

        if (this._options.parallaxAmount !== 0) {
          this._context.translate(
            0,
            this._scroll * this._options.parallaxAmount
          )
        }
        this._context.beginPath()
        this._context.moveTo(section.point1.x, section.point1.y)
        this._context.lineTo(section.point2.x, section.point2.y)
        this._context.lineTo(section.point3.x, section.point3.y)
        this._context.fillStyle = c
        this._context.fill()

        if (this._options.strokeSize > 0) {
          this._context.lineWidth = this._options.strokeSize
          this._context.strokeStyle = c
          this._context.lineCap = 'round'
          this._context.stroke()
        }
        this._context.restore()
      }
      return false // not done yet
    },

    // Draw ribbons
    _onDraw: function() {
      // cleanup on ribbons list to rtemoved finished ribbons
      for (var i = 0, t = this._ribbons.length; i < t; ++i) {
        if (!this._ribbons[i]) {
          this._ribbons.splice(i, 1)
        }
      }

      // draw new ribbons
      this._context.clearRect(0, 0, this._width, this._height)

      for (
        var a = 0;
        a < this._ribbons.length;
        ++a // single ribbon
      ) {
        var ribbon = this._ribbons[a],
          numSections = ribbon.length,
          numDone = 0

        for (
          var b = 0;
          b < numSections;
          ++b // ribbon section
        ) {
          if (this._drawRibbonSection(ribbon[b])) {
            numDone++ // section done
          }
        }
        if (numDone >= numSections) {
          // ribbon done
          this._ribbons[a] = null
        }
      }
      // maintain optional number of ribbons on canvas
      if (this._ribbons.length < this._options.ribbonCount) {
        this.addRibbon()
      }
      requestAnimationFrame(this._onDraw)
    },

    // Update container size info
    _onResize: function(e) {
      var screen = screenInfo(e)
      this._width = screen.width
      this._height = screen.height

      if (this._canvas) {
        this._canvas.width = this._width
        this._canvas.height = this._height

        if (this._context) {
          this._context.globalAlpha = this._options.colorAlpha
        }
      }
    },

    // Update container size info
    _onScroll: function(e) {
      var screen = screenInfo(e)
      this._scroll = screen.scrolly
    }
  }

  // export
  return Factory
})

new Ribbons({
  colorSaturation: '60%',
  colorBrightness: '50%',
  colorAlpha: 0.5,
  colorCycleSpeed: 5,
  verticalPosition: 'random',
  horizontalSpeed: 200,
  ribbonCount: 3,
  strokeSize: 0,
  parallaxAmount: -0.2,
  animateSections: true
})

 </script>

<!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
