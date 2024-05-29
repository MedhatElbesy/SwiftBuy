import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule,Validators } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { ProductService } from '../../../services/product.service';

@Component({
  selector: 'app-edit-product',
  standalone: true,
  imports: [CommonModule,ReactiveFormsModule],
  templateUrl: './edit-product.component.html',
  styleUrl: './edit-product.component.css'
})
export class EditProductComponent implements OnInit {
  productForm: FormGroup;
  productId: number=0;
  constructor(private formBuilder: FormBuilder,
    private router: Router,
    private productService: ProductService,
    private activatedRoute:ActivatedRoute

  ) {
    this.productForm = this.formBuilder.group({
      id: [{ value: '', disabled: true }, Validators.required],
      title: ['', Validators.required],
      description: ['', Validators.required],
      stock: ['', Validators.required],
      price: ['', [Validators.required, Validators.min(0)]],
      promotion: ['', [Validators.required, Validators.min(0)]],
      rating: ['', Validators.required],
      status: ['', Validators.required],
      category_id: ['', Validators.required]
    });
  }
  ngOnInit(): void {
    this.activatedRoute.params.subscribe((params) => {
      this.productId = params['id'];
      this.loadProduct(this.productId);

    });
  }
  loadProduct(id: number): void {
    this.productService.getProductById(id).subscribe(product => {
      this.productForm.patchValue(product);
    });
  }

  onSubmit(): void {
    if (this.productForm.valid) {
      const updatedProduct = this.productForm.getRawValue();
      this.productService.update(updatedProduct).subscribe(() => {
        this.router.navigateByUrl('/dashboard/products');
      });
    }
  }


}
