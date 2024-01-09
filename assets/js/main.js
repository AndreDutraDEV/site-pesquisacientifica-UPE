const passerSlide = 350;

function slideCarousel(carouselId, direction) {
    const carouselElement = document.querySelector(`#${carouselId}`);

    if (carouselElement) {
        const listerItems = carouselElement.querySelector(".list_items");

        if (listerItems) {

            console.log(listerItems);

            const computedStyles = window.getComputedStyle(listerItems);
            const transformValue = computedStyles.transform;
            const matrizValues = transformValue.match(/matrix\((.+)\)/);

            let quantItems = listerItems.children.length

            const largChildren = listerItems.querySelector(".item_showcase").offsetWidth;

            const widthList = quantItems * largChildren + quantItems * 24

            if (matrizValues) {
                const translate = parseFloat(matrizValues[1].split(', ')[4]);

                console.log(translate, direction);

                if (direction === "l" && translate < 0) {
                    const newTransform = Math.min(translate + passerSlide, 0);
                    listerItems.style.transform = `translateX(${newTransform}px)`;
                } else if (direction === "r" && translate > (widthList * -1)) {
                    console.log("largura", listerItems.offsetWidth);
                    const newTransform = Math.max(translate - passerSlide, widthList * -1 / 2);
                    listerItems.style.transform = `translateX(${newTransform}px)`;
                }
            }
        }
    }
}
