const Header = {
    headerImgs:document.querySelectorAll("header img"),
    headerDots:document.querySelectorAll("header .dot"),
    imgCounter:0,
    interval:null,
    slider(img1, img2) {
        img1.classList.add("previous");
        img1.classList.add("previous-z-index");
        img2.classList.add("next");
        img2.classList.add("next-z-index");
    },
    next() {
        this.imgCounter++;

        this.headerImgs.forEach((headerImg)=> {
            headerImg.classList.remove("next");
            headerImg.classList.remove("previous");
            headerImg.classList.remove("next-z-index");
            headerImg.classList.remove("previous-z-index");
        });

        this.headerDots.forEach((headerDot)=> {
            headerDot.classList.remove("selected-dot");
        });

        if(this.imgCounter < this.headerImgs.length) {
            if(this.imgCounter == 0) {
                this.slider(
                    this.headerImgs[this.headerImgs.length-1],
                    this.headerImgs[0]
                );
            } else {
                this.slider(
                    this.headerImgs[this.imgCounter-1],
                    this.headerImgs[this.imgCounter]
                );
            }
        } else {
            this.imgCounter = 0;

            this.slider(
                this.headerImgs[this.headerImgs.length-1],
                this.headerImgs[0]
            );
        }

        this.headerDots[this.imgCounter].classList.add("selected-dot");
    },
    init() {
        this.interval = setInterval(()=> {
            this.next();
        }, 6000);
    },
    selectHeader(index) {
        this.imgCounter = index-1;
        clearInterval(this.interval);
        this.next();
        this.init();
    }
};

Header.init();

const dots = document.querySelectorAll(".dot");

dots.forEach((dot, index)=> {
    dot.addEventListener("click", function() {
        Header.selectHeader(index);
    });
});