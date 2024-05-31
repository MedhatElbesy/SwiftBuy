import { Cart } from "./cart";

export class Order {
  constructor(
    public id: number,
    public total_price: string,
    public status: string,
    public created_at: Date,
    public user_id: number,
    public items: any[]
  ) {}
}

export interface OrderRequest {
  user_id: number;
//  total_price: number;
  date: string;
  status: string;
  items: Cart[];
}
