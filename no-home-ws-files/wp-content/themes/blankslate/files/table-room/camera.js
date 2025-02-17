const canvasCurrent = document.getElementById('camera-canvas-current');
   const canvasNext = document.getElementById('camera-canvas-next');
   const ctxCurrent = canvasCurrent.getContext('2d');
   const ctxNext = canvasNext.getContext('2d');
   let currentImageIndex = 1;
   const totalImages = 23;

   function loadImage(index, canvas, callback) {
     const img = new Image();
     img.crossOrigin = "Anonymous";
     img.src = `https://nohome.cloud/wp-content/themes/blankslate/files/table-room/camera/${index}.jpg`;
     img.onload = () => {
       const ctx = canvas.getContext('2d');
       ctx.clearRect(0, 0, canvas.width, canvas.height);
       ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
       callback();
     };
   }

   function pixelate(ctx, width, height, pixelSize) {
     const imageData = ctx.getImageData(0, 0, width, height);
     const data = imageData.data;
     
     for (let y = 0; y < height; y += pixelSize) {
       for (let x = 0; x < width; x += pixelSize) {
         const red = data[((y * width + x) * 4)];
         const green = data[((y * width + x) * 4) + 1];
         const blue = data[((y * width + x) * 4) + 2];
         
         for (let py = 0; py < pixelSize && y + py < height; py++) {
           for (let px = 0; px < pixelSize && x + px < width; px++) {
             const index = ((y + py) * width + (x + px)) * 4;
             data[index] = red;
             data[index + 1] = green;
             data[index + 2] = blue;
           }
         }
       }
     }
     
     ctx.putImageData(imageData, 0, 0);
   }

   function transitionImages() {
     let pixelSize = 50;
     const interval = setInterval(() => {
       pixelate(ctxCurrent, canvasCurrent.width, canvasCurrent.height, pixelSize);
       pixelate(ctxNext, canvasNext.width, canvasNext.height, pixelSize);
       pixelSize -= 5;
       if (pixelSize <= 1) {
         clearInterval(interval);
         ctxCurrent.drawImage(canvasNext, 0, 0);
         canvasNext.style.display = 'none';
       }
     }, 50);
   }

   function updateImage(direction) {
     const newImageIndex = direction === 'next' 
       ? (currentImageIndex === totalImages ? 1 : currentImageIndex + 1)
       : (currentImageIndex === 1 ? totalImages : currentImageIndex - 1);
     loadImage(newImageIndex, canvasNext, () => {
       canvasNext.style.display = 'block';
       transitionImages();
     });
     currentImageIndex = newImageIndex;
   }

   function prevImage() {
     updateImage('prev');
   }

   function nextImage() {
     updateImage('next');
   }

   // Инициализация первого изображения
   loadImage(currentImageIndex, canvasCurrent, () => {});