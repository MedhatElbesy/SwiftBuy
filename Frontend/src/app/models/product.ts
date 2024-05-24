export class Product {
  constructor(
    public id: number,
    public title: string,
    public description: string,
    public stock: string,
    public price: number,
    public rating: '1' | '2' | '3' | '4' | '5',
    public status: '0' | '1',
    public category_id: number
  ) { }
}
