import { Component } from '@angular/core';
import { Product } from '../../../models/product';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { ProductAdminService } from '../../../services/productAdmin.service';

@Component({
  selector: 'app-add-product',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './add-product.component.html',
  styleUrls: ['./add-product.component.css']
})
export class AddProductComponent {
  productForm: FormGroup;
  prd: Product = new Product(0, '', '', '', 0, '1', '1', 1);

  constructor(private productAdminService: ProductAdminService, private formBuilder: FormBuilder,private router:Router) {
    this.productForm = this.formBuilder.group({
      id: ['', Validators.required],
      title: ['', Validators.required],
      description: ['', Validators.required],
      stock: ['', Validators.required],
      price: ['', [Validators.required, Validators.min(0)]],
      rating: ['', Validators.required],
      status: ['', Validators.required],
      category_id: ['', Validators.required],
      promotion: ['']
    });
  }

  onSubmit() {
    if (this.productForm.valid) {
      const product: Product = this.productForm.value;
      this.productAdminService.addProduct(product).subscribe(d => {
        this.router.navigateByUrl('/dashboard/products');
        console.log(product);
      });
    } else {
      console.log('Form is invalid');
    }
  }
}
