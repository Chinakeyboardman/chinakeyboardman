package Paint;

import java.awt.Graphics;

abstract class SimpleShape
{
  protected java.awt.Color color;
  protected java.awt.Point p1;
  protected java.awt.Point p2;
  
  protected abstract void draw(Graphics paramGraphics);
  
  public void setP1(java.awt.Point paramPoint) {
    this.p1 = paramPoint;
  }
  
  public void setP2(java.awt.Point paramPoint) {
    this.p2 = paramPoint;
  }
  
  public void setColor(java.awt.Color paramColor) {
    this.color = paramColor;
  }
  
  private java.awt.Rectangle getRectangle() {
    if ((this.p1 == null) || (this.p2 == null)) return null;
    int i = this.p1.x;int j = this.p2.x;
    int k = this.p1.y;int m = this.p2.y;
    int n; if (i > j)
    {
      n = i;
      i = j;
      j = n;
    }
    if (k > m)
    {
      n = k;
      k = m;
      m = n;
    }
    java.awt.Rectangle localRectangle = new java.awt.Rectangle(i, k, j - i, m - k);
    return localRectangle;
  }
  
  public boolean intersects(java.awt.Point paramPoint) {
    java.awt.Rectangle localRectangle1 = getRectangle();
    if (localRectangle1 == null) return false;
    java.awt.Rectangle localRectangle2 = new java.awt.Rectangle(paramPoint);
    return localRectangle1.intersects(localRectangle2);
  }
  
  public boolean intersects(java.awt.Rectangle paramRectangle) {
    java.awt.Rectangle localRectangle = getRectangle();
    if (localRectangle == null) return false;
    return localRectangle.intersects(paramRectangle);
  }
}
