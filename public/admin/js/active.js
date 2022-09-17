const url = location.pathname;

console.log(url);

const MenuPedidoMenu = document.getElementById("menu-pedidos-li");
const MenuPedidoSubMenu = document.getElementById("pedidos-menu-div");

const MenuAdminMenu = document.getElementById("menu-administracion-li");
const MenuAdminSubMenu = document.getElementById("administracion-menu-div");

const Inicio = document.getElementById("inicio");
const Pendientes = document.getElementById("pendientes");
const Completados = document.getElementById("completados");
const Rechazados = document.getElementById("rechazados");
const DireccionCliente = document.getElementById("direcciones-clientes");

const MisPedidos = document.getElementById("mis-Rpedidios");

const PuntosI = document.getElementById("puntos");
const PuntosICompletado = document.getElementById("puntos-completados");
const PuntosIAsignacion = document.getElementById("asignacion");
const Devoluciones = document.getElementById("devoluciones");

const AdminInicio = document.getElementById("admin-inicio");
const AdminRepartidor = document.getElementById("admin-repartidores");
const AdminPedidos = document.getElementById("admin-pedidos");
const AdminComercio = document.getElementById("admin-comercios");
const AdminReparto = document.getElementById("admin-repartos");
const AdminUserReparto = document.getElementById("admin-users-repartos");

const CreacionPedidosAdmin = document.getElementById("creacion-pedidos-admin");
const DireccionesRecogidasAdmin = document.getElementById(
    "direcciones-recogida-admin"
);
const DatosClientes = document.getElementById("datos-cliente-admin");
const DireccionesClienteFinal = document.getElementById(
    "direccion-cliente-final-admin"
);

const PedidosPuntosAdmin = document.getElementById("pedidos-puntos-admin");

switch (url) {
    case "/pedidos":
        Inicio.classList.add("active");
        break;
    case "/pedidos/pendientes":
        Pendientes.classList.add("active");
        break;
    case "/pedidos/completados":
        Completados.classList.add("active");
        break;
    case "/pedidos/rechazados":
        Rechazados.classList.add("active");
        break;
    case "/mis-pedidos":
        MisPedidos.classList.add("active");
        break;
    case "/pedidos/devoluciones":
        Devoluciones.classList.add("active");
        break;
    case "/pedidos/direcciones-clientes":
        DireccionCliente.classList.add("active");
        break;

    case "/puntos-repartos/":
    case "/puntos-repartos":
        PuntosI.classList.add("active");
        break;

    case "/puntos-repartos/completados":
        PuntosICompletado.classList.add("active");
        break;

    case "/puntos-repartos/asignacion":
        PuntosIAsignacion.classList.add("active");
        break;





    case "/administracion":
        AdminInicio.classList.add("active");
        MenuAdminMenu.classList.add("active");
        MenuAdminSubMenu.classList.remove("collapse");
        break;
    case "/administracion/repartidores":
        AdminRepartidor.classList.add("active");
        MenuAdminMenu.classList.add("active");
        MenuAdminSubMenu.classList.remove("collapse");
        break;
    case "/administracion/pedidos":
        AdminPedidos.classList.add("active");
        MenuAdminMenu.classList.add("active");
        MenuAdminSubMenu.classList.remove("collapse");
        break;

    case "/administracion/comercios":
        AdminComercio.classList.add("active");
        MenuAdminMenu.classList.add("active");
        MenuAdminSubMenu.classList.remove("collapse");
        break;

    case "/administracion/puntos-de-reparto":
        AdminReparto.classList.add("active");
        MenuAdminMenu.classList.add("active");
        MenuAdminSubMenu.classList.remove("collapse");
        break;
    case "/administracion/administradores-puntos-reparto":
        AdminUserReparto.classList.add("active");
        MenuAdminMenu.classList.add("active");
        MenuAdminSubMenu.classList.remove("collapse");
        break;







    case "/administracion/creacion-pedidos":
        CreacionPedidosAdmin.classList.add("active");
        MenuPedidoMenu.classList.add("active");
        MenuPedidoSubMenu.classList.remove("collapse");
        break;

    case "/administracion/direcciones-recogida":
        DireccionesRecogidasAdmin.classList.add("active");
        MenuPedidoMenu.classList.add("active");
        MenuPedidoSubMenu.classList.remove("collapse");
        break;

    case "/administracion/datos-cliente":
        DatosClientes.classList.add("active");
        MenuPedidoMenu.classList.add("active");
        MenuPedidoSubMenu.classList.remove("collapse");
        break;

    case "/administracion/direcciones-clientes-finales":
        DireccionesClienteFinal.classList.add("active");
        MenuPedidoMenu.classList.add("active");
        MenuPedidoSubMenu.classList.remove("collapse");
        break;

        case "/administracion/pedidos-puntos-repartos":
            PedidosPuntosAdmin.classList.add("active");
            MenuPedidoMenu.classList.add("active");
            MenuPedidoSubMenu.classList.remove("collapse");
        break;
}
