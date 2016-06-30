(function () {
    var canvas, ctx, track_mouse, mouse = {},
        draw, body, H, W, particlemotion, Particle, particles = [],
        randSpeed, particlesNum;

    body = document.querySelector("body");
    canvas = document.querySelector("#canvas");
    H = window.innerHeight;
    W = window.innerWidth;
    canvas.height = H;
    canvas.width = W;
    particlesNum =20; //粒子数
    ctx = canvas.getContext("2d");

    //  鼠标监听
    track_mouse = function (e) {
        e = e || window.event;
        mouse.x = e.pageX || 1;
        mouse.y = e.pageY || 1;
    };
    body.addEventListener('mousemove', track_mouse, false);

    //  随机方法
    randSpeed = function (speed) {
        return Math.round(Math.random()) ? Math.round(Math.random() * 9 + 1) : -Math.round(Math.random() * 9 + 1);
    };

    //  粒子构造器
    Particle = function () {
        this.x = Math.round(Math.random() * W);//粒子初始x坐标
        this.y = Math.round(Math.random() * H);//粒子初始y坐标
        this.r = Math.round(Math.random() * 10 + 5);//粒子半径
        this.clr = this.r * 5.5;//绕鼠标转动半径
        this.rgb = {};//随机产生颜色
        this.rgb.r = Math.round(Math.random() * 255);
        this.rgb.g = Math.round(Math.random() * 255);
        this.rgb.b = Math.round(Math.random() * 255);
        this.speed_x = randSpeed();//x方向速度
        this.speed_y = randSpeed();//y方向速度
        this.speed_z = Math.random() + 0.5;//转动速度
        this.beginDeg = 0;
        //    默认移动方式
        this.move = function () {
            if (this.x < 0) {
                this.x = 0;
                this.speed_x = -this.speed_x;
            }
            if (this.x > W) {
                this.x = W;
                this.speed_x = -this.speed_x;
            }
            if (this.y < 0) {
                this.y = 0;
                this.speed_y = -this.speed_y;
            }
            if (this.y > H) {
                this.y = H;
                this.speed_y = -this.speed_y;
            }
            this.x += this.speed_x;
            this.y += this.speed_y;
            this.beginDeg = 0;
        };

        //    绕鼠标转动
        this.moveWithMouse = function (dt, x) {
            var rad = Math.PI / 180;
            this.x = mouse.x + dt * Math.cos(this.beginDeg * rad);

            this.y = mouse.y + dt * Math.sin(this.beginDeg * rad);
            if (this.beginDeg > 360 || this.beginDeg < -360) {
                this.beginDeg = 0.5;
            }
            if (x < 0 && this.speed_z > 0) {
                this.speed_z = -this.speed_z;
            }
            this.beginDeg += this.speed_z;
        };
    };

    for (var i = 0; i < particlesNum; i++) {
        particles.push(new Particle());
    }

    draw = function (mouse_x, mouse_y, r, rgb) {
        var rgbcolor = "rgb(" + rgb.r + "," + rgb.g + "," + rgb.b + "," + ")";
        ctx.fillStyle = "rgb(" + rgb.r + "," + rgb.g + "," + rgb.b + ")";
        ctx.beginPath();
        ctx.arc(mouse_x, mouse_y, r, 0, 2 * Math.PI);
        ctx.closePath();
        ctx.fill();
    };

    particlemotion = function () {
        ctx.clearRect(0, 0, W, H);
        for (i = 0; i < particlesNum; i++) {
            draw(particles[i].x, particles[i].y, particles[i].r, particles[i].rgb);
            var x = particles[i].x - mouse.x,
                dx = Math.abs(x),
                y = particles[i].y - mouse.y,
                dy = Math.abs(y),
                dt = Math.sqrt(dx * dx + dy * dy);
            if (dt < particles[i].clr) {
                if (particles[i].beginDeg === 0) {
                    particles[i].beginDeg = Math.acos(x / particles[i].clr);
                }
                particles[i].moveWithMouse(dt, x);
            } else {
                particles[i].move();
            }
        }
    };
    setInterval(function () {
        particlemotion();
    }, 20);

}).call(this);