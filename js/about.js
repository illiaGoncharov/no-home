const xrayButton = document.getElementById("x-ray-button");
const secondListItem = document.querySelector(".about-page-list:nth-child(2)");

if (xrayButton && secondListItem) {
  // Сохраняем оригинальный текст
  if (!secondListItem.dataset.originalText) {
    secondListItem.dataset.originalText = secondListItem.innerHTML;
  }

  const newText = `
    <ul class="about-page-list list-2">
      <li class="about-page-block-list-item" data-text="XRISTINA IDX / ART DIRECTOR / ARTIST / AI IMAGE GENERATOR…&">XRISTINA IDX / ART DIRECTOR / ARTIST / AI IMAGE GENERATOR…&</li>
      <li class="about-page-block-list-item" data-text="AMIL_NITRRITE / 3D ARTIST / AI IMAGE GENERATOR…&">AMIL_NITRRITE / 3D ARTIST / AI IMAGE GENERATOR…&</li>
      <li class="about-page-block-list-item" data-text="*ACU__238 + / SOUND ARTIST…&">*ACU__238 + / SOUND ARTIST…&</li>
      <li class="about-page-block-list-item" data-text="ANDREY LOPATIN / WEB DESIGNER / GRAPHIC DESIGNER…&">ANDREY LOPATIN / WEB DESIGNER / GRAPHIC DESIGNER…&</li>
      <li class="about-page-block-list-item" data-text="SEMIK ZLO / MOBILE DESIGNER / GRAPHIC DESIGNER…&">SEMIK ZLO / MOBILE DESIGNER / GRAPHIC DESIGNER…&</li>
      <li class="about-page-block-list-item" data-text="O0000000J / ILLUSTRATOR…&">O0000000J / ILLUSTRATOR…&</li>
      <li class="about-page-block-list-item" data-text="ANASTASIA OLEGOVNA / TRANSLATOR">ANASTASIA OLEGOVNA / TRANSLATOR</li>
      <li class="about-page-block-list-item" data-text="MAKSIM GERASIMOV / WEB DEVELOPER…&">MAKSIM GERASIMOV / WEB DEVELOPER…&</li>
      <li class="about-page-block-list-item" data-text="ILIA GONCHAROV-SERPOV / WEB DEVELOPER…&">ILIA GONCHAROV-SERPOV / WEB DEVELOPER…&</li>
      <li class="about-page-block-list-item" data-text="VLAD MD GOLAM / WEB DEVELOPER…&">VLAD MD GOLAM / WEB DEVELOPER…&</li>
    </ul>
  `;

  xrayButton.addEventListener("click", function () {
    // Проверяем, был ли уже изменен контент
    if (secondListItem.innerHTML === secondListItem.dataset.originalText) {
      secondListItem.innerHTML = newText; // Заменяем на новый контент
    } else {
      secondListItem.innerHTML = secondListItem.dataset.originalText; // Восстанавливаем исходный
    }
  });
}
