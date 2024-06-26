import { ComponentFixture, TestBed } from '@angular/core/testing';

import { OrdersComponentComponent } from './orders-component.component';

describe('OrdersComponentComponent', () => {
  let component: OrdersComponentComponent;
  let fixture: ComponentFixture<OrdersComponentComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [OrdersComponentComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(OrdersComponentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
