import { Component, OnInit } from '@angular/core';
import { ProductService } from '../../services/product.service';
import { Product } from '../../models/product';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-products',
  standalone: true,
  imports: [FormsModule,CommonModule],
  templateUrl: './products.component.html',
  styleUrl: './products.component.css'
})
export class ProductsComponent implements OnInit{
  products:Product[]=[];
  constructor(private ProductService:ProductService){}

  ngOnInit(): void {
      this.ProductService.getAllProducts().subscribe((data:any)=>{
        this.products=data;
  });
}
}
