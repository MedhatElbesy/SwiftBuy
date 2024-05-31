
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { OrderService } from '../../services/order.service';
import { Order } from '../../models/order';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-user-orders',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './user-orders.component.html',
  styleUrl: './user-orders.component.css'
})
export class UserOrdersComponent {
  constructor(public OrderService: OrderService, public router: Router) { }

  orders: Order[] = this.OrderService.orders;

  ngOnInit() {
    this.OrderService.getOrders().subscribe(data => {
      this.OrderService.orders.push(...data.data);
    });
  }

  editStatus(e: any, id: number) {
    if (e.target.value == "rejected") {
      this.OrderService.cancel(id).subscribe();
    } else if (e.target.value == "accepted") {
      this.OrderService.done(id).subscribe();
    }
  }
}
