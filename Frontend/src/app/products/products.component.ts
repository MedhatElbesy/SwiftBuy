import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';

@Component({
  selector: 'app-products',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './products.component.html',
  styleUrl: './products.component.css'
})
export class ProductsComponent {
  products: any[] = [
    {
      title: 'Product 1',
      price: 10,
      description: 'Description 1',
      stock: 5,
      rating: 4.5,
      status: '1'
    },
    {
      title: 'Product 2',
      price: 20,
      description: 'Description 2',
      stock: 10,
      rating: 3.5,
      status: '1'
    },
    {
      title: 'Product 3',
      price: 30,
      description: 'Description 3',
      stock: 15,
      rating: 5,
      status: '1'
    }
  ]
}
