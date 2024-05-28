import { Component, OnInit } from '@angular/core';
import { Product } from '../../models/product';
import { ActivatedRoute } from '@angular/router';
import { ProductService } from '../../services/product.service';

@Component({
  selector: 'app-product-details',
  standalone: true,
  imports: [],
  templateUrl: './product-details.component.html',
  styleUrl: './product-details.component.css'
})
export class ProductDetailsComponent implements OnInit {
  product: Product | null = null;
  imageDirectoryPath: any = "http://127.0.0.1:8000/public/images/";
  constructor(public activatedRoute: ActivatedRoute, public productService: ProductService) { }
  ngOnInit(): void {
    this.activatedRoute.params.subscribe((params) => {
      this.productService.getProductById(params['id']).subscribe((product) => {
        this.product = product
      })
    })
  }
  addToCart(product: any): void {

  }
}
