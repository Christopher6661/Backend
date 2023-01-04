drop database if exists recetapp;
create database recetapp;
use recetapp;

create table receta(
    id int(11) unsigned auto_increment primary key,
    categoria varchar(100) not null
);

create table entradas(
    id int(11) unsigned auto_increment primary key,
    descripcion varchar(100) not null,
    ingredientes varchar(100) not null,
    tiempo_preparacion varchar(100) not null,
    preparacion varchar(250) not null,
    id_categoria int(11) unsigned not null,
    foreign key (id_categoria) references receta(id)
);

create table platofuerte(
    id int(11) unsigned auto_increment  primary key,
    descripcion varchar(100) not null,
    ingredientes varchar(100) not null,
    tiempo_preparacion varchar(100) not null,
    preparacion varchar(250) not null,
    id_categoria int(11) unsigned not null,
    foreign key (id_categoria) references receta(id)
);

create table postres(
    id int(11) unsigned auto_increment primary key,
    descripcion varchar(100) not null,
    ingredientes varchar(100) not null,
    tiempo_preparacion varchar(100) not null,
    preparacion varchar(250) not null,
    id_categoria int(11) unsigned not null,
    foreign key (id_categoria) references receta(id)
);

insert into receta values (null, 'Entrada');
insert into receta values (null, 'Plato fuerte');
insert into receta values (null, 'Postres');

insert into entradas values (null, 'Sopa de Fideo', 'Ingredientes: 2 chucharadas de aceite vegetal, 1 Paquete de pasta de fideos (200 g), litro 1/2 de caldo de pollo, 3 jitomates en trozos, 1/4 de pieza de cebolla en trozos, 1 diente de ajo, 2 cubos de concentrado de tomate con pollo, 2 ramitas de cilantro fresco desinfectado', '22 minutos', '1. Calienta el aceite y fríe el fideo hasta que dore ligeramente, 2. Licúa 2 tazas de caldo de pollo con los jitomates, la cebolla, el ajo y el concentrado de tomate con pollo, cuela y vierte lo licuado sobre los fideos, agrega el caldo de pollo restante, el cilantro y cocia hasta que hierva, 3. Retira el cilantro, sirve y ofrece.', 1);

insert into platofuerte values (null, 'Cochinita Pibil', 'Ingredientes: 75 Gramos de achiote, 3/4 De taza jugo de naranja agria, 1/2 Cucharadita de pimienta negra molida, 1/4 De pieza de raja de canela, 2 Tazas de agua, 1/2 Cucharada de comino molido, 3 Clavos de olor, 1 Cucharada de sal, 1/4 De taza de manteca de cerdo fundida, 4 Hojas de plátano asadas, 1 Kilogramo de cabeza de lomo de cerdo, 2 Chiles habanero fileteados, 1 Cebolla morada fileteada, 1/4 De taza de jugo de naranja agria, 1/2 Cucharadita de sal, 1/4 De cucharadita de orégano seco molido, Tortillas de maíz calientes', '5 horas', 'Marina la carne: 1. Horno precalentado a 180 ° C, 2. Licúa el achiote con ¾ taza de jugo de naranja, la pimienta, la canela, el agua, el comino, los clavos de olor, la sal y la manteca de cerdo; vierte sobre la carne de cerdo, cubre con plástico adherente y marina en refrigeración por 3 horas, Cocina la carne: 3. Forra un refractario con las hojas de plátano, coloca la carne con la marinada, cubre con más hojas de plátano y papel aluminio. Hornea a 180 °C de 2 a 2 ½ horas; retira del horno. Deshebra la carne, colócala en una sartén con el líquido de cocción y cocina hasta que espese, Prepara las cebollitas con habanero: 4. Para las cebollitas encurtidas, mezcla los chiles habaneros, la cebolla morada, el jugo de naranja restante, la sal y el orégano. Forma los tacos con las tortillas, la cochinita y las cebollas encurtidas. Ofrece.', 2);

insert into postres values (null, 'Flan Napolitano', 'Ingredientes: 3/4 De taza de azúcar refinada, 1 Lata de Leche Condensada, 1 Lata de Leche Evaporada, 1 Paquete de queso crema a temperatura ambiente (190 g), 5 Huevos, 1 Cucharada de esencia de vainilla', '2 horas', 'Calienta: 1. Horno precalentado a 180 °C, 2. Vierte el azúcar en una flanera y calienta a fuego medio para que se forme el caramelo, ladea con cuidado el molde para cubrir la superficie y las paredes, Cocina: 3. Licúa la Leche Condensada con la Leche Evaporada, el queso crema, los huevos y la esencia de vainilla, Vierte la preparación en la flanera y tapa con papel aluminio sellando las orillas, coloca en un recipiente y cocina a baño María en el horno a 180 °C durante 1 1/2 horas, Sirve: 4. Retira del fuego y deja enfriar por completo, desmolda y sirve.', 3);