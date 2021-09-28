
// let Login = require('../components/Auth/Login.vue').default;
import NotFound from "../components/NotFound";

// AUTHENTICATION COMPONENTS
import Login from "../components/Auth/Login";
import Logout from "../components/Auth/Logout";
import Register from "../components/Auth/Register";
import ForgetPassword from "../components/Auth/ForgetPassword";
// END AUTHENTICATION COMPONENTS


import Dashboard from "../components/Backend/Dashboard";

// EMPLOYEE COMPONENTS AREA
import AddEmployee from "../components/Employee/AddEmployee";
import AllEmployee from "../components/Employee/AllEmployee";
import Edit from "../components/Employee/Edit";

// SUPPLIERS COMPONENT AREA
import SupplierList from "../components/Suppliers/SupplierList";
import AddSupplier from "../components/Suppliers/AddSupplier";
import EditSupplier from "../components/Suppliers/EditSupplier"

// CATEGORY COMPONENT AREA
import CategoryList from "../components/Category/CategoryList";
import EditCategory from "../components/Category/EditCategory";
import AddCategory from "../components/Category/AddCategory";

// CATEGORY COMPONENT AREA
import ProductList from "../components/Product/ProductList";
import EditProduct from "../components/Product/EditProduct";
import AddProduct from "../components/Product/AddProduct";

// EXPENSE COMPONENT AREA
import AddExpense from "../components/Expense/AddExpense";
import EditExpense from "../components/Expense/EditExpense";
import ExpenseList from "../components/Expense/ExpenseList";

// SALARY COMPONENT AREA
import PaidEmployeeList from "../components/Salary/PaidEmployeeList";
import PayableEmployeeList from "../components/Salary/PayableEmployeeList";
import PaySalary from "../components/Salary/PaySalary";
import ViewPaidSalaryMonth from "../components/Salary/ViewPaidSalaryMonth";
import EditSalary from "../components/Salary/EditSalary";

// STOCK COMPONENT AREA
import Stock from "../components/Stock/Stock";
import EditStock from "../components/Stock/EditStock";

// CUSTOMER COMPONENT AREA
import AddCustomer from "../components/Customer/AddCustomer";
import CustomerList from "../components/Customer/CustomerList";
import EditCustomer from "../components/Customer/EditCustomer";
import ViewCustomer from "../components/Customer/ViewCustomer";

// POS COMPONENT AREA
import PointOfSale from "../components/Pos/PointOfSale";

// VAT COMPONENT AREA
import Vat from "../components/Vat/Vat";
import EditVat from "../components/Vat/EditVat";

// ORDER COMPONENT AREA
import Order from "../components/Order/Order";
import OrderDetails from "../components/Order/OrderDetails";
import SearchOrder from "../components/Order/SearchOrder";
import AllOrder from "../components/Order/AllOrder";

export const routes = [
    { path: '*', name: 'NotFound', component: NotFound },

    { path: '/', name: 'Login', component: Login },
    { path: '/register', name: 'Register', component: Register },
    { path: '/logout', name: 'Logout', component: Logout },
    { path: '/forget-password', name: 'ForgetPassword', component: ForgetPassword },
    { path: '/dashboard', name: 'Dashboard', component: Dashboard },
    // Employee Routes
    { path: '/employee/list', name: 'AllEmployee', component: AllEmployee },
    { path: '/employee/new', name: 'AddEmployee', component: AddEmployee },
    { path: '/employee/edit/:id', name: 'EditEmployee', component: Edit },
    // Supplier Routes
    { path: '/supplier/list', name: 'SupplierList', component: SupplierList },
    { path: '/supplier/new', name: 'AddSupplier', component: AddSupplier },
    { path: '/supplier/edit/:id', name: 'EditSupplier', component: EditSupplier },
    // Category Routes
    { path: '/category/list', name: 'CategoryList', component: CategoryList },
    { path: '/category/add', name: 'AddCategory', component: AddCategory },
    { path: '/category/edit/:id', name: 'EditCategory', component: EditCategory },
    // Product Routes
    { path: '/product/list', name: 'ProductList', component: ProductList },
    { path: '/product/add', name: 'AddProduct', component: AddProduct },
    { path: '/product/edit/:id', name: 'EditProduct', component: EditProduct },
    // Expense Routes
    { path: '/expense/list', name: 'ExpenseList', component: ExpenseList },
    { path: '/expense/add', name: 'AddExpense', component: AddExpense },
    { path: '/expense/edit/:id', name: 'EditExpense', component: EditExpense },
    // Salary Routes
    { path: '/payable/list', name: 'PayableEmployeeList', component: PayableEmployeeList },
    { path: '/payable/pay/:id', name: 'PaySalary', component: PaySalary },
    { path: '/paid/list', name: 'PaidEmployeeList', component: PaidEmployeeList },
    { path: '/paid/month/:month', name: 'ViewPaidSalaryMonth', component: ViewPaidSalaryMonth },
    { path: '/paid/edit/:id', name: 'EditSalary', component: EditSalary },

    // Stock Routes
    { path: '/stock/all', name: 'Stock', component: Stock },
    { path: '/stock/edit/:id', name: 'EditStock', component: EditStock },

    // Customer Routes
    { path: '/customer/list', name: 'CustomerList', component: CustomerList },
    { path: '/customer/add', name: 'AddCustomer', component: AddCustomer },
    { path: '/customer/edit/:id', name: 'EditCustomer', component: EditCustomer },
    { path: '/customer/view/:id', name: 'ViewCustomer', component: ViewCustomer },

    // Point Of Sale Routes
    { path: '/dashboard/pos', name: 'PointOfSale', component: PointOfSale },

    // Vat Routes
    { path: '/vat', name: 'Vat', component: Vat },
    { path: '/vat/update/:id', name: 'EditVat', component: EditVat },

    // Order Routes
    { path: '/order/today', name: 'Orders', component: Order },
    { path: '/order/details/:id', name: 'OrderDetails', component: OrderDetails },
    { path: '/order/search', name: 'SearchOrder', component: SearchOrder },
    { path: '/order/all', name: 'AllOrder', component: AllOrder },

]
