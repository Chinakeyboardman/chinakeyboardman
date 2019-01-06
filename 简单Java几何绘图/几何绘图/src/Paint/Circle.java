package Paint;

import java.awt.Color;
import java.awt.Graphics;
import java.awt.Point;

class Circle
  extends SimpleShape
{
  public Circle() {}
  
  public Circle(Point paramPoint1, Point paramPoint2)
  {
    this.p1 = paramPoint1;
    this.p2 = paramPoint2;
  }
  
  public Circle(Color paramColor) {
    this.color = paramColor;
  }
  
  public Circle(Point paramPoint, Color paramColor) {
    this.p1 = paramPoint;
    this.color = paramColor;
  }
  
  public void draw(Graphics paramGraphics)
  {
    if ((this.p1 == null) || (this.p2 == null)) { return;
    }
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
    Color localColor = paramGraphics.getColor();
    paramGraphics.setColor(this.color);
    paramGraphics.drawOval(i, k, j - i, m - k);
    paramGraphics.setColor(localColor);
  }
}

