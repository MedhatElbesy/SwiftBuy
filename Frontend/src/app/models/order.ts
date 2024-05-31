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
