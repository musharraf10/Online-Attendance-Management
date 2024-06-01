<?php
include('connect.php');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

    if(isset($_SESSION["username"]))
	{
		session_destroy();
    }
    
    $ref=@$_GET['q'];
if (isset($_POST['login'])) {
    try {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            throw new Exception("Both username and password are required!");
        }

        // Establishing connection with db
        include('connect.php');

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $role = mysqli_real_escape_string($conn, $_POST['type']);

        $query = "SELECT * FROM admininfo WHERE username=? AND password=? AND type=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $password, $role);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $_SESSION['username'] = $username;

            if ($role === 'teacher') {
                $query = "SELECT course FROM teacher_course_mapping WHERE teacher_username = ?";
                $stmt1 = $conn->prepare($query);
                $stmt1->bind_param("s", $username);
                $stmt1->execute();
                $stmt1->bind_result($teacherCourse);
    
                if ($stmt1->fetch()) {
                    $_SESSION['course'] = $teacherCourse;
                }
                $stmt1->close();
            }	

			if ($role === 'student') {
                $queryStudentInfo = "SELECT st_dept, st_sem, st_id FROM students WHERE st_username = ?";
                $stmtStudentInfo = $conn->prepare($queryStudentInfo);
                $stmtStudentInfo->bind_param("s", $username);
                $stmtStudentInfo->execute();
                $stmtStudentInfo->bind_result($studentDept, $studentSem, $studentId);
                
                if ($stmtStudentInfo->fetch()) {
                    $_SESSION['st_dept'] = $studentDept;
                    $_SESSION['st_sem'] = $studentSem;
                    $_SESSION['st_id'] = $studentId;       
            }
            $stmtStudentInfo->close();
        }
            switch ($role) {
                case 'teacher':
                    header('Location: teacherindex.php');
                    break;
                case 'student':
                    header('Location: studenthome.php');
                    break;
                case 'admin':
                    header('Location: adminindex.php');
                    break;
            }
            exit();

        } else {
            throw new Exception("Invalid username, password, or role.");
        }
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Attendence</title>
  <style>

    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    html, body {
      background-color: #403060;
   background-image: radial-gradient( circle, rgba(  0, 0, 0, 0 ) 0%, rgba( 0, 0, 0, 0.8 ) 100% );
   background-position: center center;
   background-repeat: no-repeat;
   background-attachment: fixed;
   background-size: cover;
      display: flex; 
      justify-content: center; 
      align-items: center;
      height: 100vh;
      background: #f2f2f2;
    }
     .radio-group {
    display: flex; /* Use flexbox for a horizontal layout */
    gap: 13px; /* Adjust the spacing between radio buttons */
}

.radio-label {
    display: inline-flex; /* Align the label and radio button horizontally */
    align-items: center; /* Center align items vertically */
}
    ::selection {
      background: #4158d0;
      color: #fff;
    }
    .wrapper {
      width: 380px;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
    }
    .wrapper .title {
      font-size: 35px;
      font-weight: 600;
      text-align: center;
      line-height: 100px;
      color: #fff;
      user-select: none;
      border-radius: 15px 15px 0 0;
      background: linear-gradient(-135deg, #c850c0, #4158d0);
      /* Add animation */
      animation: fadeInUp 1.5s ease forwards;
    }
    .wrapper form {
      padding: 10px 30px 50px 30px;
    }
    .wrapper form .field {
      height: 50px;
      width: 100%;
      margin-top: 20px;
      position: relative;
    }
    .wrapper form .field input {
      height: 100%;
      width: 100%;
      outline: none;
      font-size: 17px;
      padding-left: 20px;
      border: 1px solid lightgrey;
      border-radius: 25px;
      transition: all 0.3s ease;
    }
    .wrapper form .field input:focus,
    form .field input:valid {
      border-color: #4158d0;
    }
    .wrapper form .field label {
      position: absolute;
      top: 50%;
      left: 20px;
      color: #999999;
      font-weight: 400;
      font-size: 17px;
      pointer-events: none;
      transform: translateY(-50%);
      transition: all 0.3s ease;
    }
    form .field input:focus ~ label,
    form .field input:valid ~ label {
      top: 0%;
      font-size: 16px;
      color: #4158d0;
      background: #fff;
      transform: translateY(-50%);
    }
    form .content {
      display: flex;
      width: 100%;
      height: 50px;
      font-size: 16px;
      align-items: center;
      justify-content: space-around;
    }
    form .content .checkbox {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    form .content input {
      width: 15px;
      height: 15px;
      background: red;
    }
    form .content label {
      color: #262626;
      user-select: none;
      padding-left: 5px;
    }
    form .content .pass-link {
      color: "";
    }
    .login-btn:active {
        transform: scale(0.95);
    }
    form .signup-link {
      color: #262626;
      margin-top: 20px;
      text-align: center;
    }
    form .pass-link a,
    form .signup-link a {
      color: #4158d0;
      text-decoration: none;
    }
    form .pass-link a:hover,
    form .signup-link a:hover {
      text-decoration: underline;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media screen and (max-width: 480px) {
      .wrapper {
        width: 100%;
        border-radius: 0;
      }
      .wrapper .title {
        font-size: 30px;
        line-height: 80px;
      }
      .wrapper form {
        padding: 10px 20px 30px 20px;
      }
    }

    @media screen and (min-width: 768px) {
      .wrapper {
        width: 450px;
      }
    }

    body {
      overflow: hidden;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="title">
      Login
    </div>
    <form method="post">
    <form action="#">
      <div class="field">
        <input type="text" name="username" required>
        <label>Username</label>
      </div>
      <div class="field">
        <input type="password" name="password" required>
        <label>Password</label>
      </div>
      <div class="content">
        <div class="checkbox">

        </div>
<div class="radio-group">
    <label class="radio-label">
        <input type="radio" name="type" value="admin" checked> Admin
    </label>
    <label class="radio-label">
        <input type="radio" name="type" value="teacher"> Teacher
    </label>
    <label class="radio-label">
        <input type="radio" name="type" value="student"> Student
    </label>
</div>

      </div>
      <div class="field">
<button type="submit" class="login-btn" name="login"
        style="color: #fff;
               width:100%;
               border: none;
               padding: 10px 30px;
               margin-top: -10px;
               font-size: 20px;
               font-weight: 500;
               cursor: pointer;
               background: linear-gradient(-135deg, #c850c0, #4158d0);
               border-radius: 50px; /* Increase the border-radius for more curvature */
               transition: all 0.3s ease;">
    Login
</button>

      </div>
      <div class="signup-link">
        Not a member? <a href="signup.php">Signup now</a>
      </div>
      <div class="signup-link">
          Forgot Password?<a href="resetpassword.php">reset here</a>
        </div>
    </form>
  </div>

<script>
    const bubbleContainer = document.querySelector('.bubble-container');
    const numBubbles = 50;
    
    for (let i = 0; i < numBubbles; i++) {
      const bubble = document.createElement('div');
      bubble.classList.add('bubble');
      bubble.style.left = `${Math.random() * 100}vw`;
      bubble.style.animationDuration = `${Math.random() * 3 + 1}s`;
      bubbleContainer.appendChild(bubble);
    }
 
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
<script type = "text/javascript" >
   document.addEventListener("wheel", function(event) {
    if ($(event.target).closest('.disable-back-forward').length)
        event.preventDefault();
}, { passive: false });
</script>


</body>
</html>
