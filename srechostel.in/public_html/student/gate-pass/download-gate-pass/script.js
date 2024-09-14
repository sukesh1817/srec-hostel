window.onload = function() {
    const img = document.getElementById('sourceImage');
    if (!img) return;

    img.onload = function() {
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.drawImage(img, 0, 0);

        const svgData = convertCanvasToSVG(canvas);
        const svgContainer = document.getElementById('svgContainer');
        svgContainer.innerHTML = svgData;
    };

    img.src = img.src; // Trigger the onload event if image is already loaded
};

function convertCanvasToSVG(canvas) {
    const svgHeader = '<?xml version="1.0" encoding="UTF-8"?>\n<svg xmlns="http://www.w3.org/2000/svg" width="' + canvas.width + '" height="' + canvas.height + '" viewBox="0 0 ' + canvas.width + ' ' + canvas.height + '">\n';
    const svgFooter = '</svg>';
    const canvasData = canvas.toDataURL('image/png');
    const image = '<image href="' + canvasData + '" width="' + canvas.width + '" height="' + canvas.height + '"/>\n';
    return svgHeader + image + svgFooter;
}
