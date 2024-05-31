import { Component, OnInit } from '@angular/core';
import { ProductService } from '../../services/product.service';
import { Product } from '../../models/product';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Router, RouterLink } from '@angular/router';
import { ProductAdminService } from '../../services/productAdmin.service';

@Component({
  selector: 'app-products',
  standalone: true,
  imports: [FormsModule,CommonModule,RouterLink],
  templateUrl: './products.component.html',
  styleUrl: './products.component.css'
})
export class ProductsComponent implements OnInit{
  products:Product[]=[];
  imageDirectoryPath: any = "http://127.0.0.1:8000/images/";

  constructor(private ProductAdminService:ProductAdminService, private router:Router){}

  ngOnInit(): void {
      this.ProductAdminService.getAllProducts().subscribe((data:any)=>{
        this.products=data;
  });
}
goToAdd(){
  this.router.navigate(['/dashboard/product/add']);
}

toggleStatus(product: Product): void {
  const newStatus = product.status === '1' ? '0' : '1'; // Toggle status
  this.ProductAdminService.updateProductStatus(product.id, newStatus).subscribe(() => {
    product.status = newStatus;
  });
}
}
