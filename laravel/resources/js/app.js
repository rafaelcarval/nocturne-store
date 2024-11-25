import './bootstrap';



document.addEventListener("DOMContentLoaded", () => {
    const mainImage = document.getElementById("mainImage");
    const thumbnails = document.querySelectorAll(".thumb-image");
    const zoomLens = document.getElementById("zoomLens");

    if (!mainImage || !zoomLens) {
        console.error("Erro: Elementos principais não encontrados.");
        return;
    }

    // Trocar a imagem principal ao clicar nas miniaturas
    thumbnails.forEach((thumb) => {
        thumb.addEventListener("click", (event) => {
            const newSrc = event.target.dataset.large;
            mainImage.src = newSrc;
            zoomLens.style.backgroundImage = `url(${newSrc})`;
        });
    });

    // Mostrar o zoom ao passar o mouse na imagem principal
    mainImage.addEventListener("mousemove", (event) => {
        const bounds = mainImage.getBoundingClientRect();
        const x = event.pageX - bounds.left - window.scrollX;
        const y = event.pageY - bounds.top - window.scrollY;

        const zoomX = (x / bounds.width) * 100;
        const zoomY = (y / bounds.height) * 100;

        zoomLens.style.backgroundImage = `url(${mainImage.src})`;
        zoomLens.style.backgroundSize = `${bounds.width * 2}px ${bounds.height * 2}px`;
        zoomLens.style.backgroundPosition = `${zoomX}% ${zoomY}%`;
        zoomLens.style.display = "block"; // Exibe o zoom
    });

    // Ocultar o zoom ao sair da imagem principal
    mainImage.addEventListener("mouseleave", () => {
        zoomLens.style.display = "none";
    });
});

