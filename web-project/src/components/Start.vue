<template>
  <div>
    <div class="container">
      <div class="row">
        <!-- Post Product Section -->
        <div class="col-md-6">
          <!-- Post Product Card -->
          <div class="card mb-3">
            <div class="card-header">Post Product</div>
            <div class="card-body">
              <!-- Product Form -->
              <div class="form-group">
                <label>Product Name</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="productName"
                  placeholder="Name"
                />
              </div>
              <div class="form-group">
                <label>Detail 1</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="productDetail1"
                  placeholder="Detail 1"
                />
              </div>
              <div class="form-group">
                <label>Detail 2</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="productDetail2"
                  placeholder="Detail 2"
                />
              </div>
              <button @click="postProduct" class="btn btn-primary">Post</button>
            </div>
          </div>
        </div>

        <!-- Delete Product Section -->
        <div class="col-md-6">
          <!-- Delete Product Card -->
          <div class="card mb-3">
            <div class="card-header">Delete Product</div>
            <div class="card-body">
              <!-- Product Deletion Form -->
              <div class="form-group">
                <label>Product Name</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="deleteProductName"
                  placeholder="Product Name"
                />
              </div>
              <button @click="deleteProduct" class="btn btn-danger">
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Get Product Section -->
      <div class="row">
        <div class="col-md-6">
          <div class="card mb-3">
            <div class="card-header">Get Product</div>
            <div class="card-body">
              <div class="form-group">
                <label>Product Name</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="product"
                  placeholder="Product Name"
                />
              </div>
              <button @click="getProduct" class="btn btn-primary">Get</button>
            </div>
          </div>
        </div>

        <!-- Get Categories Section -->
        <div class="col-md-6">
          <div class="card mb-3">
            <div class="card-header">Get Categories</div>
            <div class="card-body">
              <button @click="getCategories" class="btn btn-primary">
                Get Categories
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Get Users and Orders Section -->
      <div class="row">
        <div class="col-md-6">
          <div class="card mb-3">
            <div class="card-header">Get Users</div>
            <div class="card-body">
              <button @click="getUsers" class="btn btn-primary">
                Get Users
              </button>
              <button @click="getUser" class="btn btn-primary">Get User</button>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card mb-3">
            <div class="card-header">Get Orders and Products</div>
            <div class="card-body">
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  v-model="order"
                  placeholder="Order Name"
                />
                <input
                  type="text"
                  class="form-control"
                  v-model="productForOrder"
                  placeholder="Product Name"
                />
              </div>
              <div class="d-flex justify-content-between">
                <button @click="getOrder" class="btn btn-primary">
                  Get Order
                </button>
                <button @click="getProduct" class="btn btn-primary">
                  Get Product
                </button>
                <button
                  @click="getAllProductsAndOrders"
                  class="btn btn-primary"
                >
                  Get All
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import { Vue } from "vue-class-component";

const BASE_URL = "/";

interface Category {
  id: number;
  description: string;
}

interface Order {
  id: number;
  productId: number;
  quantity: string;
  price: number;
}

interface Product {
  id: number;
  name: string;
  price: number;
  description: string;
  availableQuantity: string;
  categoryId: number;
}

interface User {
  id: number;
  username: string;
  email: string;
  role: string;
  password: string;
}

export default class Start extends Vue {
  product = "";
  productName = "";
  productDetail1 = "";
  productDetail2 = "";
  order = "";
  productForOrder = "";
  deleteProductName = "";

  async deleteProduct() {
    try {
      await axios.delete(
        `${BASE_URL}/products/delete/${this.deleteProductName}`
      );
      console.log("Product deleted");
    } catch (error) {
      console.error("Error deleting product:", error);
    }
  }

  async postProduct() {
    const product: Product = {
      id: 0, // Placeholder value or whatever default value makes sense
      name: this.productName,
      description: this.productDetail1 + " " + this.productDetail2,
      price: 0, // Set appropriate value
      availableQuantity: "0", // Set appropriate value
      categoryId: 0, // Set appropriate value
    };

    try {
      const response = await axios.post(`${BASE_URL}/products`, product);
      console.log("Product posted:", response.data);
    } catch (error) {
      console.error("Error posting product:", error);
    }
  }

  async getProduct() {
    try {
      const response = await axios.get(`${BASE_URL}/products/${this.product}`);
      console.log("Product:", response.data);
    } catch (error) {
      console.error("Error getting product:", error);
    }
  }

  async getCategories() {
    try {
      const response = await axios.get<Category[]>(`${BASE_URL}/categories`);
      console.log("Categories:", response.data);
    } catch (error) {
      console.error("Error getting categories:", error);
    }
  }

  async getUsers() {
    try {
      const response = await axios.get<User[]>(`${BASE_URL}/users`);
      console.log("Users:", response.data);
    } catch (error) {
      console.error("Error getting users:", error);
    }
  }

  async getUser() {
    try {
      const userId = 1; // Replace with the actual user ID you want to retrieve
      const response = await axios.get<User>(`${BASE_URL}/users/${userId}`);
      console.log("User:", response.data);
    } catch (error) {
      console.error("Error getting user:", error);
    }
  }

  async getOrder() {
    try {
      const orderId = 1; // Replace with the actual order ID you want to retrieve
      const response = await axios.get<Order>(`${BASE_URL}/orders/${orderId}`);
      console.log("Order:", response.data);
    } catch (error) {
      console.error("Error getting order:", error);
    }
  }

  async getAllProductsAndOrders() {
    try {
      const response = await axios.get(`${BASE_URL}/products-and-orders`);
      console.log("All Products and Orders:", response.data);
    } catch (error) {
      console.error("Error getting all products and orders:", error);
    }
  }
}
</script>

<style scoped>
.d-flex {
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 1rem;
}

.form-control {
  margin-bottom: 0.5rem;
}

.btn {
  margin-right: 0.5rem;
}
</style>
