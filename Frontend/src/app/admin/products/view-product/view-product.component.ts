import { Component,OnInit } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { Product } from '../../../models/product';
import { ProductService } from '../../../services/product.service';

@Component({
  selector: 'app-view-product',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './view-product.component.html',
  styleUrl: './view-product.component.css'
})
export class ViewProductComponent {

  product: Product | null = null;
  imageDirectoryPath: any = "http://127.0.0.1:8000/images/";
  constructor(public activatedRoute: ActivatedRoute, public productService: ProductService) { }
  ngOnInit(): void {
    this.activatedRoute.params.subscribe((params) => {
      this.productService.getProductById(params['id']).subscribe((product) => {
        this.product = product
      })
    })
  }
  

}



