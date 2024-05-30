import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ProductAdminService } from '../../../services/productAdmin.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-delete-product',
  templateUrl: './delete-product.component.html',
  styleUrls: ['./delete-product.component.css']
})
export class DeleteProductComponent implements OnInit {
  productId: number = 0;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private productAdminService: ProductAdminService
  ) { }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.productId = +params['id'];
    });

    this.deleteProduct();
  }

  deleteProduct(): void {
    Swal.fire({
      title: 'Are you sure?',
      text: 'Are you sure you want to delete this product?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, keep it'
    }).then((result) => {
      if (result.isConfirmed) {
        // User confirmed deletion, proceed with deletion
        this.productAdminService.deleteProduct(this.productId).subscribe(() => {
          // Navigate back to the product list page after deletion
          this.router.navigateByUrl('/dashboard/products');
        });
      } else {
        // User canceled deletion, do nothing
      }
    });
  }
}
