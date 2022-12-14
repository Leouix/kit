<h1>Тестовое задание</h1>

Необходимо создать две страницы:
  1) для просмотра пользователями
  2) для администратора

<h3> Страница администратора</h3>
<ol>
  <li>Вход на страницу администрирования осуществляется только авторизованными пользователями по логину и паролю. Логин и пароль хранятся в базе данных, причем пароль – в зашифрованном виде.</li>
 <li>В случае успешной авторизации, администратор допускается до редактирования «структуры данных». «Структура данных» представляет из себя дерево объектов, состоящих из двух полей:
 <ul>
      <li> - название,</li>
     <li> - описание.</li>
  </ul>
    Каждый объект может являться потомком другого объекта и быть родителем других объектов. При этом родитель у объекта только один, а потомков неограниченное множество. Глубина дерева не ограничена. Объекты, не имеющие родителей, являются корневыми.
Объекты хранятся в базе данных.
  <li>Администратор видит текущее состояние «структуры данных», при этом визуально обозначена иерархия объектов в дереве (например, количеством отступов слева в зависимости от уровня вложенности объекта). </li>
  <li>С помощью находящихся на странице форм администратор имеет возможность:
    <ul>
      <li>- добавлять объект на любой уровень дерева;</li>
      <li>- удалять любой объект, при этом если у удаляемого объекта имеются потомки, то они также удаляются;</li>
      <li>- редактировать любой объект, изменяя его название, описание или родителя.</li>
    </ul>
  <li>Все произведенные изменения сохраняются в базе данных.</li>
    
  <li>Нажав на соответствующую кнопку, администратор может разлогиниться, покинув страницу администрирования.</li>
</ol>


<h3>Страница пользователя</h3>
<ol>
  <li>Страница открыта для всех и на ней в виде дерева отображается «структура данных», заведенная администратором на странице администрирования. Иерархия объектов отображается визуально, при этом показаны только названия объектов.</li>
  <li>По умолчанию отображаются только корневые объекты. Если у какого-то из объектов имеются потомки, то справа от его названия отображается иконка (например, плюс), при нажатии на которую показываются потомки первого уровня данного объекта. Если у какого-то из потомков первого уровня  в свою очередь имеются потомки, то они также отображаются только после нажатия на иконку справа от названия их родителя. Это правило действует для объектов любого уровня.</li>
  <li>При нажатии на название объекта в отдельном блоке на странице (например, справа от дерева) отображается его описание. Если описания нет, то блок отображается пустым.</li>
</ol>

<h3>Требования к выполнению задания</h3>
  <ol>
    <li>Реализация задания на PHP 5, JavaScript, HTML (приветствуется использование HTML5 и CSS3). В качестве базы данных используется MySQL.</li>
    <li>Задание необходимо выполнить без применения фреймворков (как PHP, так и JavaScript, то есть использовать jQuery не нужно) и использования стороннего кода.</li>
    <li>JavaScript и стили, используемые на странице, должны быть кроссбраузерными: Chrome, Firefox, Opera, Safari.</li>
    <li>Внедрение системы  валидации введенных  данных не обязательно, защита «от дурака» и от взлома не требуется, однако, безусловно, будет приветствоваться.</li>
    <li>Требования к стилистическому оформлению страниц минимальные, необходима лишь понятность интерфейса.</li>
  </ol>
  <hr>
# Kit App
# PHP >= 5.6, MySql

Инструкция по запуску приложения:

0. Клонировать файлы к себе на сервер git clone https://github.com/Leouix/kit.git kit, создать базу данных;
1. Заполнить информацию о БД в /config/db_params.php;
2. Создать админа по урл /register, залогиниться;
3. Страница админа находится по адресу /admin;
4. Публичная страница для пользователей на главной странице сайта;
5. Enjoy!
