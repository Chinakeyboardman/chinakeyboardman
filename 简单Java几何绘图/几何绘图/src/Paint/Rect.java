package Paint;

import java.awt.Color;
import java.awt.Graphics;
import java.awt.Point;

class Rect
  extends SimpleShape
{
  public Rect() {}
  
  public Rect(Point paramPoint1, Point paramPoint2)
  {
    this.p1 = paramPoint1;
    this.p2 = paramPoint2;
  }
  
  public Rect(Point paramPoint1, Point paramPoint2, Color paramColor) {
    this(paramPoint1, paramPoint2);
    setColor(paramColor);
  }
  
  public Rect(Point paramPoint, Color paramColor) {
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
    paramGraphics.drawRect(i, k, j - i, m - k);
    paramGraphics.setColor(localColor);
  }
}
